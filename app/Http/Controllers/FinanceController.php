<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseFee;
use App\Models\FeeCategory;
use App\Models\StudentFee;
use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index()
    {
        $totalCollected = Payment::sum('amount');
        $totalFees = StudentFee::sum('amount');
        $outstandingBalance = StudentFee::whereIn('status', ['unpaid', 'partial'])->get()->sum(fn ($f) => $f->balance);
        $totalStudentsWithFees = StudentFee::distinct('student_id')->count('student_id');
        $recentPayments = Payment::with(['student', 'studentFee.feeCategory', 'user'])
            ->latest()
            ->take(10)
            ->get();
        $feeCategories = FeeCategory::where('is_active', true)->get();
        $categoryBreakdown = FeeCategory::withSum('studentFees', 'amount')->get();

        return view('finance.index', compact(
            'totalCollected',
            'totalFees',
            'outstandingBalance',
            'totalStudentsWithFees',
            'recentPayments',
            'feeCategories',
            'categoryBreakdown'
        ));
    }

    public function categories()
    {
        $categories = FeeCategory::withCount('studentFees')->orderBy('name')->get();
        return view('finance.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('finance.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:fee_categories,name',
            'description' => 'nullable|string',
        ]);

        FeeCategory::create($request->only(['name', 'description']));

        return redirect('/finance/categories')->with('success', __('Fee category created successfully.'));
    }

    public function editCategory(FeeCategory $feeCategory)
    {
        return view('finance.categories.edit', compact('feeCategory'));
    }

    public function updateCategory(Request $request, FeeCategory $feeCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:fee_categories,name,' . $feeCategory->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $feeCategory->update($request->only(['name', 'description', 'is_active']));

        return redirect('/finance/categories')->with('success', __('Fee category updated successfully.'));
    }

    public function destroyCategory(FeeCategory $feeCategory)
    {
        if ($feeCategory->studentFees()->exists()) {
            return redirect('/finance/categories')->with('error', __('Cannot delete category with assigned fees.'));
        }

        $feeCategory->delete();

        return redirect('/finance/categories')->with('success', __('Fee category deleted successfully.'));
    }

    public function assign()
    {
        $students = Student::orderBy('fullname')->get();
        $courses = Course::orderBy('name')->get();
        $categories = FeeCategory::where('is_active', true)->orderBy('name')->get();
        $assignedFees = StudentFee::with(['student', 'course', 'feeCategory'])->latest()->paginate(20);
        $courseFees = CourseFee::with(['course', 'feeCategory'])->latest()->get();

        return view('finance.assign', compact('students', 'courses', 'categories', 'assignedFees', 'courseFees'));
    }

    public function storeAssign(Request $request)
    {
        $request->validate([
            'assignment_type' => 'required|in:student,course',
            'student_id' => 'required_if:assignment_type,student|exists:students,id',
            'course_id' => 'required_if:assignment_type,course|exists:courses,id',
            'fee_category_id' => 'required|exists:fee_categories,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date',
            'academic_year' => 'nullable|string|max:255',
            'term' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = [
            'fee_category_id' => $request->fee_category_id,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'academic_year' => $request->academic_year,
            'term' => $request->term,
            'description' => $request->description,
            'status' => 'unpaid',
        ];

        if ($request->assignment_type === 'course') {
            $students = Student::where('course_id', $request->course_id)->get();

            DB::transaction(function () use ($request, $data, $students) {
                foreach ($students as $student) {
                    StudentFee::updateOrCreate(
                        [
                            'student_id' => $student->id,
                            'course_id' => $request->course_id,
                            'fee_category_id' => $data['fee_category_id'],
                            'academic_year' => $data['academic_year'],
                            'term' => $data['term'],
                        ],
                        $data + ['student_id' => $student->id, 'course_id' => $request->course_id]
                    );
                }

                CourseFee::updateOrCreate(
                    [
                        'course_id' => $request->course_id,
                        'fee_category_id' => $data['fee_category_id'],
                        'academic_year' => $data['academic_year'],
                        'term' => $data['term'],
                    ],
                    [
                        'amount' => $data['amount'],
                        'due_date' => $data['due_date'],
                        'description' => $data['description'],
                    ]
                );
            });

            return redirect('/finance/assign')
                ->with('success', __('Fee assigned to all students in the course.'));
        }

        StudentFee::create(array_merge($data, [
            'student_id' => $request->student_id,
        ]));

        return redirect('/finance/assign')->with('success', __('Fee assigned successfully.'));
    }

    public function recordPayment(Request $request, StudentFee $studentFee = null)
    {
        $student = null;
        $fee = $studentFee;

        if ($request->has('student_id')) {
            $student = Student::findOrFail($request->student_id);
        }

        $students = Student::orderBy('fullname')->get();
        $fees = StudentFee::with(['student', 'feeCategory'])->whereIn('status', ['unpaid', 'partial'])->get();

        return view('finance.payments.create', compact('students', 'fees', 'student', 'fee'));
    }

    public function storePayment(Request $request)
    {
        $request->validate([
            'student_fee_id' => 'required|exists:student_fees,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,cheque,mobile_money',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $studentFee = StudentFee::findOrFail($request->student_fee_id);

        DB::transaction(function () use ($request, $studentFee) {
            Payment::create([
                'student_fee_id' => $studentFee->id,
                'student_id' => $studentFee->student_id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'reference_number' => $request->reference_number,
                'notes' => $request->notes,
                'user_id' => Auth::id(),
            ]);

            $paidAmount = $studentFee->payments()->sum('amount') + $request->amount;

            if ($paidAmount >= $studentFee->amount) {
                $studentFee->update(['status' => 'paid']);
            } elseif ($paidAmount > 0) {
                $studentFee->update(['status' => 'partial']);
            }
        });

        return redirect('/finance')->with('success', __('Payment recorded successfully.'));
    }

    public function studentFees($id)
    {
        $student = Student::with(['studentFees.feeCategory', 'studentFees.payments'])->findOrFail($id);

        return view('finance.student', compact('student'));
    }

    public function editFee(StudentFee $studentFee)
    {
        $categories = FeeCategory::where('is_active', true)->orderBy('name')->get();
        return view('finance.edit-fee', compact('studentFee', 'categories'));
    }

    public function updateFee(Request $request, StudentFee $studentFee)
    {
        $request->validate([
            'fee_category_id' => 'required|exists:fee_categories,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'nullable|date',
            'academic_year' => 'nullable|string|max:255',
            'term' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:unpaid,partial,paid',
        ]);

        $studentFee->update($request->only([
            'fee_category_id', 'amount', 'due_date',
            'academic_year', 'term', 'description', 'status',
        ]));

        return redirect('/finance/student/' . $studentFee->student_id)->with('success', __('Fee updated successfully.'));
    }

    public function destroyFee(StudentFee $studentFee)
    {
        $studentId = $studentFee->student_id;
        $studentFee->delete();

        return redirect('/finance/student/' . $studentId)->with('success', __('Fee record deleted successfully.'));
    }

    public static function assignCourseFeesForStudent(Student $student): void
    {
        if (!$student->course_id) return;

        $courseFees = CourseFee::where('course_id', $student->course_id)->get();

        foreach ($courseFees as $courseFee) {
            StudentFee::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'course_id' => $student->course_id,
                    'fee_category_id' => $courseFee->fee_category_id,
                    'academic_year' => $courseFee->academic_year,
                    'term' => $courseFee->term,
                ],
                [
                    'amount' => $courseFee->amount,
                    'due_date' => $courseFee->due_date,
                    'description' => $courseFee->description,
                    'status' => 'unpaid',
                ]
            );
        }
    }

    public function paymentHistory(StudentFee $studentFee)
    {
        $studentFee->load(['payments.user', 'student', 'feeCategory']);
        return view('finance.payments.history', compact('studentFee'));
    }

    public function destroyPayment(Payment $payment)
    {
        $studentFee = $payment->studentFee;

        DB::transaction(function () use ($payment, $studentFee) {
            $payment->delete();

            $paidAmount = $studentFee->payments()->sum('amount');

            if ($paidAmount <= 0) {
                $studentFee->update(['status' => 'unpaid']);
            } elseif ($paidAmount < $studentFee->amount) {
                $studentFee->update(['status' => 'partial']);
            } else {
                $studentFee->update(['status' => 'paid']);
            }
        });

        return redirect('/finance/payments/' . $studentFee->id . '/history')
            ->with('success', __('Payment record deleted successfully.'));
    }
}
