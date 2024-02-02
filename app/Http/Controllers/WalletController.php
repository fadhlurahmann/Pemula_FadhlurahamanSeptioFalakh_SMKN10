<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function TopUpNow(Request $request)
    {
        $user_id = Auth::user()->id;
        $credit = $request->credit;
        $status = "proses";
        $desc = 'Top Up Saldo';

        Wallet::create([
            'user_id' => $user_id,
            'credit' => $credit,
            'status' => $status,
            'description' => $desc
        ]);

        return redirect()->back()->with('status', 'Berhasil Top Up, Silahkan Menunggu Konfirmasi');
    }

    public function topupFromBank(Request $request){
        $credit = $request->credit;
        $status = "selesai";
        $desc = 'Top Up Saldo';

        Wallet::create([
            'user_id' => $request->user_id,
            'credit' => $credit,
            'status' => $status,
            'description' => $desc
        ]);


        return redirect()->back()->with('status', 'berhasil');
    }

    public function withdrawFromBank(Request $request){
        $debit = $request->debit;
        $status = "selesai";
        $desc = 'withdraw';

        Wallet::create([
            'user_id' => $request->user_id,
            'debit' => $debit,
            'status' => $status,
            'description' => $desc
        ]);

        return redirect()->back()->with('status', 'berhasil ');
    }
    

    public function withdrawNow(Request $request)
    {
        $user_id = Auth::user()->id;
        $debit = $request->debit;
        $status = "proses";
        $desc = 'narik uang';

        Wallet::create([
            'user_id' => $user_id,
            'debit' => $debit,
            'status' => $status,
            'description' => $desc
        ]);

        return redirect()->back()->with('status', 'Berhasil withdraw, Silahkan Menunggu Konfirmasi');
    }

    public function request_topup(Request $request)
    {
        Wallet::find($request->id)->update([
            'status' => 'selesai'
        ]);

        return redirect()->back()->with('status', 'Berhasil Konfirmasi Top Up Nasabah');

    }

}