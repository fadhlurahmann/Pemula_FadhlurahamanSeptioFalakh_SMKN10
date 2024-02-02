<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(auth()->user()->role_id);
        if(Auth::user()->role_id == 'bank'){
            $wallets = Wallet::where('status', 'selesai')->where('user_id', 'siswa')->get();
            $credit = 0;
            $debit = 0;
    
            foreach($wallets as $wallet){
                $credit += $wallet->credit;
                $debit += $wallet->debit;
            }

            $saldo = $credit - $debit;
            
            $nasabah = User::where('role_id', 'siswa')->get()->count();
            $users = User::where('role_id', 'siswa')->get();

            $transactionsAll = Transaction::all()->count();
            $request_topup = Wallet::where('status', 'proses')->get();
            $mutasi = Wallet::where('status', 'selesai')->orderBy('created_at', 'DESC')->get();
            $transactions = collect(Transaction::get())->sortByDesc('created_at')->groupBy('code');

            return view('home', compact('saldo', 'nasabah', 'transactionsAll', 'transactions' , 'mutasi','request_topup', 'users'));
        }
        if(Auth::user()->role_id == 'siswa'){

            $wallets = Wallet::where('user_id', Auth::user()->id)->where('status', 'selesai')->get();
            $credit = 0;
            $debit = 0;
            foreach($wallets as $wallet)
            {
                $credit += $wallet->credit;
                $debit += $wallet->debit;
            }
            $saldo = $credit - $debit;
            $products = Product::all();
            $carts = Transaction::where('status', 'dikeranjang')->where('user_id', Auth::user()->id)->get();
    
            $total_biaya = 0;
    
            foreach($carts as $cart){
                $total_price = $cart->price * $cart->quantity;
                $total_biaya += $total_price;
            }
    
            $mutasi = Wallet::where('user_id', Auth::user()->id)->orderBy('created_at','DESC')->get();
            $transactions = Transaction::where('status', 'dibayar')->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(5)->groupBy('order_code');
            
            return view('home', compact('products', 'carts', 'saldo', 'total_biaya','mutasi','transactions'));
        }

        if(Auth::user()->role_id == 'kantin'){
            $products = Product::all();
            $categories = Category::all();
            
            $transactions = collect(Transaction::get())->sortByDesc('created_at')->groupBy('code');
            return view('home', compact('products','categories','transactions'));
        }
        if(Auth::user()->role_id == 'admin'){
            $users = User::all();
            $products = Product::all()->count();
            $nasabah = User::all()->count();
            $categories = Category::all()->count();
            $transactionsAll = Transaction::all()->count();
            $mutasi = Wallet::where('status', 'selesai')->orderBy('created_at', 'DESC')->get();
            $transactions = collect(Transaction::get())->sortByDesc('created_at')->groupBy('code');
            return view('home', compact( 'mutasi', 'transactions', 'users','nasabah','categories','products','transactionsAll'));
        }
    }


    public function logoutmanual(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}