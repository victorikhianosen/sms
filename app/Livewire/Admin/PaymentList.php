<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Exports\PaymentsExport;
use Livewire\Attributes\Validate;

use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PaymentList extends Component
{
    use WithPagination;

    public $email, $amount, $status, $transaction_id, $reference;
    public $bank_name, $account_number, $card_last_four, $card_brand;
    public $currency, $description, $payment_type, $created_at;

    #[Title('Payment List')]
    public $search = '';

    public $editModel = false;

    public $downloadModel = false;

    #[Validate('required')]
    public $start_date;
    #[Validate('required')]
    public $end_date;

    public $account_type;


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $payments = Payment::query()
            ->with(['user', 'admin']) // Load both relationships
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('transaction_id', 'like', '%' . $this->search . '%')
                        ->orWhereHas('user', function ($query) {
                            $query->where('email', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('admin', function ($query) { // Search by admin email too
                            $query->where('email', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('amount', 'like', $this->search)
                        ->orWhere('amount', 'like', $this->search . '%')
                        ->orWhere('amount', 'like', '%' . $this->search);
                });
            })
            ->latest()
            ->paginate(perPage: 10);


        // dd($payments);

        return view('livewire.admin.payment-list', [
            'payments' => $payments,
        ])->extends('layouts.admin_layout')->section('admin-section');
    }


    public function closeModal()
    {
        $this->editModel = false;
        $this->downloadModel = false;
    }

    public function viewPayment($id)
    {
        $this->editModel = true;

        // dd($id);
        $payment = Payment::find($id);
        // dd($payment);
        $this->email = $payment->user->email ?? $payment->admin->email ?? 'N/A';
        $this->amount = $payment->amount;
        $this->status = $payment->status;
        $this->transaction_id = $payment->transaction_id;
        $this->reference = $payment->reference;
        $this->bank_name = $payment->bank_name;
        $this->account_number = $payment->account_number;
        $this->card_last_four = $payment->card_last_four;
        $this->card_brand = $payment->card_brand;
        $this->currency = $payment->currency;
        $this->description = $payment->description;
        $this->payment_type = $payment->payment_type;
        $this->created_at = $payment->created_at->toDateTimeString();
        $this->account_type = $payment->user ? 'User' : ($payment->admin ? 'Admin' : 'N/A');
    }

    public function showDownload() {
        $this->downloadModel = true;
    }



    public function DownloadPayments()
    {
        $this->validate();

        $payments = Payment::whereBetween('created_at', [$this->start_date, $this->end_date])->get();

        if ($payments->isEmpty()) {
            $this->dispatch('alert', type: 'error', text: 'No payments found for the selected date range', position: 'center', timer: 10000, button: false);
            return;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add headers
        $headers = [
            'Email',
            'Amount',
            'Status',
            'Transaction ID',
            'Reference',
            'Bank Name',
            'Account Number',
            'Card Last Four',
            'Card Brand',
            'Currency',
            'Description',
            'Payment Type',
            'Created At',
            'Account Type'
        ];
        $sheet->fromArray([$headers], null, 'A1');

        // Add payment records
        $row = 2;
        foreach ($payments as $payment) {
            $sheet->fromArray([
                $payment->user->email ?? $payment->admin->email ?? 'N/A',
                $payment->amount,
                $payment->status,
                $payment->transaction_id,
                $payment->reference,
                $payment->bank_name,
                $payment->account_number,
                $payment->card_last_four,
                $payment->card_brand,
                $payment->currency,
                $payment->description,
                $payment->payment_type,
                $payment->created_at,
                $payment->user ? 'User' : ($payment->admin ? 'Admin' : 'N/A'),
            ], null, "A{$row}");
            $row++;
        }

        // Save the Excel file to a temporary path
        $fileName = 'payments_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        $tempPath = storage_path($fileName);
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempPath);

        // Return file as response
        return Response::download($tempPath)->deleteFileAfterSend(true);
    }






    // public function DownloadPayments()
    // {
    //     $this->validate();

    //     $payments = Payment::whereBetween('created_at', [$this->start_date, $this->end_date])->get();

    //     // dd($payments);
    //     if ($payments->isEmpty()) {
    //         $this->dispatch('alert', type: 'error', text: 'No payments found for the selected date range', position: 'center', timer: 10000, button: false);
    //         return;
    //     }

    //     // Generate a unique file name
    //     $fileName = 'payments_' . now()->format('Y-m-d_H-i-s') . '.csv';

    //     return response()->streamDownload(function () use ($payments) {
    //         $file = fopen('php://output', 'w');

    //         // Add CSV headers
    //         fputcsv($file, [
    //             'Email',
    //             'Amount',
    //             'Status',
    //             'Transaction ID',
    //             'Reference',
    //             'Bank Name',
    //             'Account Number',
    //             'Card Last Four',
    //             'Card Brand',
    //             'Currency',
    //             'Description',
    //             'Payment Type',
    //             'Created At',
    //             'Account Type'
    //         ]);

    //         // Add payment records
    //         foreach ($payments as $payment) {
    //             fputcsv($file, [
    //                 $payment->user->email ?? $payment->admin->email ?? 'N/A',
    //                 $payment->amount,
    //                 $payment->status,
    //                 $payment->transaction_id,
    //                 $payment->reference,
    //                 $payment->bank_name,
    //                 $payment->account_number,
    //                 $payment->card_last_four,
    //                 $payment->card_brand,
    //                 $payment->currency,
    //                 $payment->description,
    //                 $payment->payment_type,
    //                 $payment->created_at,
    //                 $payment->user ? 'User' : ($payment->admin ? 'Admin' : 'N/A'),
    //             ]);
    //         }

    //         fclose($file);
    //     }, $fileName, [
    //         "Content-Type" => "text/csv",
    //         "Cache-Control" => "no-cache, must-revalidate",
    //         "Expires" => "0"
    //     ]);
    // }



    // public function DownloadPayments() {
    //     $validated = $this->validate();
    // }
}
