<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use App\Transaction;
use Illuminate\Http\Request;
use App\Helpers\UUIDGenerate;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePassword;
use App\Notifications\GeneralNotification;
use App\Http\Requests\TransferFormValidate;
use Illuminate\Support\Facades\Notification;

class PageController extends Controller
{
    //

    public function home()
    {

        $user = Auth::guard()->user();

        
        return view('frontend.home', compact('user'));
    }

    public function profile()
    {

        $user = Auth::guard()->user();
        return view('frontend.profile', compact('user'));
    }

    public function updatePassword()
    {

        return view('frontend.update_password');
    }

    public function updatePasswordStore(UpdatePassword $request)
    {

        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $user = Auth::guard('web')->user();

        if (Hash::check($old_password, $user->password)) {

            $user->password = Hash::make($new_password);
            $user->update();

            $title ='Changed Password !';
            $message='Your account password is succcessfully changed.';
            $sourceable_id=$user->id;
            $sourceable_type=User::class;
            $web_link=url('profile');
            $deep_link= [
                'target' => 'profile',
                'parameter'=> null,
            ];

            Notification::send([$user],new GeneralNotification($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link));

            return redirect()->route('profile')->with('update', 'Successfully Updated');
        }
        return back()->withErrors(['old_password' => 'The old password is not correct.'])->withInput();
    }

    public function wallet()
    {

        $user = Auth::guard()->user();
        return view('frontend.wallet', compact('user'));
    }

    public function transfer()
    {

        $user = Auth::guard()->user();
        return view('frontend.transfer', compact('user'));
    }

    public function transferConfirm(TransferFormValidate $request)
    {
        $authUser = auth()->guard('web')->user();
        $from_account = $authUser;

        $user = Auth::guard()->user();
        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $description = $request->description;
        $hash_value = $request->hash_value;

        $str = $to_phone.$amount.$description;
        $hash_value2 = hash_hmac('sha256',$str,'noelkhant!@#');

        if($hash_value !== $hash_value){
            return back()->withErrors(['fail' => 'The given data invalid']);
        }

        if ($amount < 1000) {
            return back()->withErrors(['amount' => 'The amount must be at least 1000 MMK'])->withInput();
        }

        

        if ($authUser->phone == $to_phone) {
            return back()->withErrors(['to_phone' => 'Account invalid'])->withInput();
        }

        $to_account = User::where('phone', $to_phone)->first();
        if (!$to_account) {
            return back()->withErrors(['to_phone' => 'Account invalid'])->withInput();
        }

        if($authUser->wallet->amount<=$amount){
            return back()->withErrors(['amount' => "Your balance is Low!"])->withInput();
        }
        

        if (!$from_account->wallet || !$to_account->wallet) {

            return back()->withErrors(['fail' => 'Something wrong'])->withInput();
        }

       
        return view('frontend.transfer_confirm', compact('from_account','hash_value', 'to_account', 'amount', 'description'));
    }

    public function toAccountVerify(Request $request)
    {

        $authUser = auth()->guard('web')->user();

        if ($authUser->phone != $request->phone) {
            $user = User::where('phone', $request->phone)->first();
            if ($user) {

                return response()->json([
                    'status' => 'success',
                    'data' => $user
                ]);
            }
        }
        return response()->json([
            'status' => 'fail',
        ]);
    }


    public function transferComplete(TransferFormValidate $request)
    {
        $authUser = auth()->guard('web')->user();
        $from_account = $authUser;

        $user = Auth::guard()->user();
        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $description = $request->description;
        $hash_value = $request->hash_value;

        $str = $to_phone.$amount.$description;
        $hash_value2 = hash_hmac('sha256',$str,'noelkhant!@#');

        if($hash_value !== $hash_value){
            return back()->withErrors(['fail' => 'The given data invalid']);
        }

        if ($amount < 1000) {
            return back()->withErrors(['amount' => 'The amount must be at least 1000 MMK'])->withInput();
        }

        

        if ($authUser->phone == $to_phone) {
            return back()->withErrors(['to_phone' => 'Account invalid'])->withInput();
        }

        $to_account = User::where('phone', $to_phone)->first();
        if (!$to_account) {
            return back()->withErrors(['to_phone' => 'Account invalid'])->withInput();
        }

        if($authUser->wallet->amount<=$amount){
            return back()->withErrors(['amount' => "Your balance is Low!"])->withInput();
        }
        

        if (!$from_account->wallet || !$to_account->wallet) {

            return back()->withErrors(['fail' => 'Something wrong'])->withInput();
        }

        DB::beginTransaction();
        try{
            $from_account_wallet=$from_account->wallet;
            $from_account_wallet->decrement('amount',$amount);
            $from_account_wallet->update();
    
            $to_account_wallet=$to_account->wallet;
            $to_account_wallet->increment('amount',$amount);
            $to_account_wallet->update();
            
            $ref_no = UUIDGenerate::refNumber();
            $from_account_transaction= new Transaction();
            $from_account_transaction->ref_no= $ref_no;
            $from_account_transaction->trx_id= UUIDGenerate::trxId();
            $from_account_transaction->user_id= $from_account->id;
            $from_account_transaction->type= 2;
            $from_account_transaction->amount= $amount;
            $from_account_transaction->source_id= $to_account->id;
            $from_account_transaction->description= $description;
            $from_account_transaction->save();

            $to_account_transaction= new Transaction();
            $to_account_transaction->ref_no= $ref_no;
            $to_account_transaction->trx_id= UUIDGenerate::trxId();
            $to_account_transaction->user_id= $to_account->id;
            $to_account_transaction->type= 1;
            $to_account_transaction->amount= $amount;
            $to_account_transaction->source_id= $from_account->id;
            $to_account_transaction->description= $description;
            $to_account_transaction->save();

            //from Noti
            $title ='E-money Transfered!';
            $message='Your wallet transfered ' . number_format($amount) . ' MMK to ' .$to_account->name .'('. $to_account->phone .')' ;
            $sourceable_id= $from_account_transaction->id;
            $sourceable_type=Transaction::class;
            $web_link=url('/transaction/'. $from_account_transaction->trx_id);
            $deep_link= [
                'target' => 'transaction_detail',
                'parameter'=> [
                    'trx_id' => $from_account_transaction->trx_id,
                ],
            ];
            Notification::send([$from_account],new GeneralNotification($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link));

            //to Noti
            $title ='E-money Recieve!';
            $message='Your wallet recieved ' . number_format($amount) .' MMK from ' .$from_account->name .'('. $from_account->phone .')';
            $sourceable_id= $to_account_transaction->id;
            $sourceable_type=Transaction::class;
            $web_link=url('/transaction/'. $to_account_transaction->trx_id);
            $deep_link= [
                'target' => 'transaction_detail',
                'parameter'=> [
                    'trx_id' => $to_account_transaction->trx_id,
                ],
            ];
            Notification::send([$to_account],new GeneralNotification($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link));


            DB::commit();
            return redirect('/transaction/'. $from_account_transaction->trx_id)->with('transfer_success', 'Successfully Transfered!');
        } catch(\Exception $error){
            DB::rollBack();
            return back()->withErrors(['fail' => 'Something wrong' . $error->getMessage()])->withInput();
        }
       
    }

    public function passwordCheck(Request $request)
    {

        if (!$request->password) {

            return response()->json([
                'status' => 'fail',
                'message' => 'Please fill your password',
            ]);
        }

        $authUser = auth()->guard('web')->user();

        if (Hash::check($request->password, $authUser->password)) {
            return response()->json([
                'status' => 'success',
                'message' => 'The password is correct.',
            ]);
        }
        return response()->json([
            'status' => 'fail',
            'message' => 'The password is incorrect.',
        ]);
    }

    public function transaction(Request $request){

        $authUser = auth()->guard('web')->user();
        $transactions = Transaction::with('user','source')->orderBy('created_at','DESC')->where('user_id',$authUser->id);
       
        if($request->type){
            $transactions = $transactions->where('type',$request->type);
        }

        if($request->date){
            $transactions = $transactions->whereDate('created_at',$request->date);
        }

        $transactions = $transactions->paginate(5);
        return view('frontend.transaction',compact('transactions'));
    }

    public function transactionDetail($trx_id){

        $authUser = auth()->guard('web')->user();
        $transaction = Transaction::with('user','source')->where('user_id',$authUser->id)->where('trx_id',$trx_id)->first();
        return view('frontend.transaction_detail',compact('transaction'));
    }


    public function transferHash(Request $request){

        $str = $request->to_phone.$request->amount.$request->description;
        $hash_value = hash_hmac('sha256',$str,'noelkhant!@#');

        return response()->json([
            'status' => 'success',
            'data' => $hash_value,
        ]);

    }

    public function recieveQR(){

        $authUser = auth()->guard('web')->user();
        return view('frontend.recieve_qr',compact('authUser'));
    }

    public function scanAndPay(){

        // $authUser = auth()->guard('web')->user();
        return view('frontend.scan_and_pay');
    }

    public function scanAndPayForm(Request $request){
        $from_account = auth()->guard('web')->user();
        $to_account = User::where('phone',$request->to_phone)->first();
        if(!$to_account){
            return back()->withErrors(['fail' => 'QR code is iinvalid'])->withInput();
        }
        return view('frontend.scan_and_pay_form',compact('from_account','to_account'));
    }

    public function scanAndPayConfirm(TransferFormValidate $request)
    {
        $authUser = auth()->guard('web')->user();
        $from_account = $authUser;

        $user = Auth::guard()->user();
        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $description = $request->description;
        $hash_value = $request->hash_value;

        $str = $to_phone.$amount.$description;
        $hash_value2 = hash_hmac('sha256',$str,'noelkhant!@#');

        if($hash_value !== $hash_value){
            return back()->withErrors(['fail' => 'The given data invalid']);
        }

        if ($amount < 1000) {
            return back()->withErrors(['amount' => 'The amount must be at least 1000 MMK'])->withInput();
        }

        

        if ($authUser->phone == $to_phone) {
            return back()->withErrors(['to_phone' => 'Account invalid'])->withInput();
        }

        $to_account = User::where('phone', $to_phone)->first();
        if (!$to_account) {
            return back()->withErrors(['to_phone' => 'Account invalid'])->withInput();
        }

        if($authUser->wallet->amount<=$amount){
            return back()->withErrors(['amount' => "Your balance is Low!"])->withInput();
        }
        

        if (!$from_account->wallet || !$to_account->wallet) {

            return back()->withErrors(['fail' => 'Something wrong'])->withInput();
        }

       
        return view('frontend.scan_and_pay_confirm', compact('from_account','hash_value', 'to_account', 'amount', 'description'));
    }

    public function scanAndPayComplete(TransferFormValidate $request)
    {
        $authUser = auth()->guard('web')->user();
        $from_account = $authUser;

        $user = Auth::guard()->user();
        $to_phone = $request->to_phone;
        $amount = $request->amount;
        $description = $request->description;
        $hash_value = $request->hash_value;

        $str = $to_phone.$amount.$description;
        $hash_value2 = hash_hmac('sha256',$str,'noelkhant!@#');

        if($hash_value !== $hash_value){
            return back()->withErrors(['fail' => 'The given data invalid']);
        }

        if ($amount < 1000) {
            return back()->withErrors(['amount' => 'The amount must be at least 1000 MMK'])->withInput();
        }

        

        if ($authUser->phone == $to_phone) {
            return back()->withErrors(['to_phone' => 'Account invalid'])->withInput();
        }

        $to_account = User::where('phone', $to_phone)->first();
        if (!$to_account) {
            return back()->withErrors(['to_phone' => 'Account invalid'])->withInput();
        }

        if($authUser->wallet->amount<=$amount){
            return back()->withErrors(['amount' => "Your balance is Low!"])->withInput();
        }
        

        if (!$from_account->wallet || !$to_account->wallet) {

            return back()->withErrors(['fail' => 'Something wrong'])->withInput();
        }

        DB::beginTransaction();
        try{
            $from_account_wallet=$from_account->wallet;
            $from_account_wallet->decrement('amount',$amount);
            $from_account_wallet->update();
    
            $to_account_wallet=$to_account->wallet;
            $to_account_wallet->increment('amount',$amount);
            $to_account_wallet->update();
            
            $ref_no = UUIDGenerate::refNumber();
            $from_account_transaction= new Transaction();
            $from_account_transaction->ref_no= $ref_no;
            $from_account_transaction->trx_id= UUIDGenerate::trxId();
            $from_account_transaction->user_id= $from_account->id;
            $from_account_transaction->type= 2;
            $from_account_transaction->amount= $amount;
            $from_account_transaction->source_id= $to_account->id;
            $from_account_transaction->description= $description;
            $from_account_transaction->save();

            $to_account_transaction= new Transaction();
            $to_account_transaction->ref_no= $ref_no;
            $to_account_transaction->trx_id= UUIDGenerate::trxId();
            $to_account_transaction->user_id= $to_account->id;
            $to_account_transaction->type= 1;
            $to_account_transaction->amount= $amount;
            $to_account_transaction->source_id= $from_account->id;
            $to_account_transaction->description= $description;
            $to_account_transaction->save();

             //from Noti
             $title ='E-money Transfered!';
             $message='Your wallet transfered ' . number_format($amount) . ' MMK to ' .$to_account->name .'('. $to_account->phone .')' ;
             $sourceable_id= $from_account_transaction->id;
             $sourceable_type=Transaction::class;
             $web_link=url('/transaction/'. $from_account_transaction->trx_id);
             $deep_link= [
                'target' => 'transaction_detail',
                'parameter'=> [
                    'trx_id' => $from_account_transaction->trx_id,
                ],
            ];
             Notification::send([$from_account],new GeneralNotification($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link));
 
             //to Noti
             $title ='E-money Recieve!';
             $message='Your wallet recieved ' . number_format($amount) .' MMK from ' .$from_account->name .'('. $from_account->phone .')';
             $sourceable_id= $to_account_transaction->id;
             $sourceable_type=Transaction::class;
             $web_link=url('/transaction/'. $to_account_transaction->trx_id);
             $deep_link= [
                'target' => 'transaction_detail',
                'parameter'=> [
                    'trx_id' => $from_account_transaction->trx_id,
                ],
            ];
             Notification::send([$to_account],new GeneralNotification($title,$message,$sourceable_id,$sourceable_type,$web_link,$deep_link));
 

            DB::commit();
            return redirect('/transaction/'. $from_account_transaction->trx_id)->with('transfer_success', 'Successfully Transfered!');
        } catch(\Exception $error){
            DB::rollBack();
            return back()->withErrors(['fail' => 'Something wrong' . $error->getMessage()])->withInput();
        }
       
    }

}
