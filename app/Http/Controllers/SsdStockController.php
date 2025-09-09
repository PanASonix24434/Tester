<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ssd;

class SsdStockController extends Controller
{
    /**
     * Display the SSD stock application form.
     */
    public function index()
    {
        return view('app.ssd_stock.permohonan');
    }

    /**
     * Display SSD inventory.
     */
    public function inventory()
    {
        $ssds = Ssd::with(['createdByUser', 'updatedByUser'])->get();
        return view('app.ssd_stock.inventory', compact('ssds'));
    }

    /**
     * Display SSD stock requests.
     */
    public function request()
    {
        return view('app.ssd_stock.request');
    }

    /**
     * Display key-in SSD form.
     */
    public function keyIn()
    {
        return view('app.ssd_stock.key_in');
    }

    /**
     * Display key-out SSD form.
     */
    public function keyOut()
    {
        return view('app.ssd_stock.key_out');
    }

    /**
     * Display SSD transfer management.
     */
    public function transfer()
    {
        return view('app.ssd_stock.transfer');
    }

    /**
     * Display monthly transfer.
     */
    public function monthlyTransfer()
    {
        return view('app.ssd_stock.monthly_transfer');
    }

    /**
     * Display SSD disposal management.
     */
    public function disposal()
    {
        return view('app.ssd_stock.disposal');
    }

    /**
     * Display SSD assignment.
     */
    public function assignment()
    {
        return view('app.ssd_stock.assignment');
    }

    /**
     * Display SSD reports.
     */
    public function reports()
    {
        return view('app.ssd_stock.reports');
    }

    /**
     * Display semakan sokongan page.
     */
    public function semakanSokongan()
    {
        return view('app.ssd_stock.semakan_sokongan');
    }

    /**
     * Display semakan keputusan page.
     */
    public function semakanKeputusan()
    {
        return view('app.ssd_stock.semakan_keputusan');
    }

    /**
     * Display semakan key out page.
     */
    public function semakanKeyOut()
    {
        return view('app.ssd_stock.semakan_key_out');
    }

    /**
     * Display semakan key in page.
     */
    public function semakanKeyIn()
    {
        return view('app.ssd_stock.semakan_key_in');
    }

    /**
     * Display semakan key in KDP page.
     */
    public function semakanKeyInKdp()
    {
        return view('app.ssd_stock.semakan_key_in_kdp');
    }

    /**
     * Display pelupusan SSD KDP page.
     */
    public function pelupusanSsdKdp()
    {
        return view('app.ssd_stock.pelupusan_ssd_kdp');
    }

    /**
     * Store SSD stock application.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tarikh_permohonan' => 'required|date',
            'kuantiti' => 'required|array',
            'kuantiti.*' => 'required|integer|min:0'
        ]);

        // Process the form data
        $data = [
            'tarikh_permohonan' => $request->tarikh_permohonan,
            'kuantiti' => $request->kuantiti,
            'created_by' => auth()->id(),
        ];

        // Add your business logic here
        // For example, save to database, send notifications, etc.

        return redirect()->back()->with('success', 'Permohonan Stok SSD berjaya disimpan!');
    }

    /**
     * Submit SSD stock application.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'tarikh_permohonan' => 'required|date',
            'kuantiti' => 'required|array',
            'kuantiti.*' => 'required|integer|min:0'
        ]);

        // Process the form submission
        $data = [
            'tarikh_permohonan' => $request->tarikh_permohonan,
            'kuantiti' => $request->kuantiti,
            'status' => 'submitted',
            'submitted_by' => auth()->id(),
            'submitted_at' => now(),
        ];

        // Add your business logic here
        // For example, save to database, send notifications, etc.

        return redirect()->back()->with('success', 'Permohonan Stok SSD berjaya dihantar!');
    }

    /**
     * Display the Semakan Key Out KCSPT page
     */
    public function semakanKeyOutKcspt()
    {
        return view('app.ssd_stock.semakan_key_out_kcspt');
    }

    /**
     * Display the Semakan Key Out PPN page
     */
    public function semakanKeyOutPpn()
    {
        return view('app.ssd_stock.semakan_key_out_ppn');
    }
}
