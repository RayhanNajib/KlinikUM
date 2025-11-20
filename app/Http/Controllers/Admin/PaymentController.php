<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['appointment.patient.user', 'appointment.schedule.doctor.user'])
            ->latest()
            ->get();

        return view('admin.payment.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        return view('admin.payment.invoice', compact('payment'));
    }

    public function markAsPaid(Payment $payment)
    {
        $payment->update([
            'status' => 'Lunas'
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi LUNAS. Dokter sekarang bisa mencetak dokumen.');
    }
}