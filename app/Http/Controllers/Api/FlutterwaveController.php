<?php

namespace App\Http\Controllers\Api;

use App\Models\CvFormat;
use App\Models\CvPricing;
use App\Models\CvTransaction;
use App\Services\Flutterwave;
use Illuminate\Http\Request;
use App\Models\Ref;
use App\Models\UserWallet;
use App\Models\Deposit as DepositModel;
use App\Models\WalletHistory;
use App\Models\Transaction;
use App\Models\UserCardDetail;
use Illuminate\Support\Str;

class FlutterwaveController extends Controller
{
    public function selectCvFormat(Request $request){

        $cv_format  = CvFormat::where('id', $request->formatid);
        $cv_pricing  = CvPricing::where('id', $request->pricingid);
        $cv_Transaction = CvTransaction::create([
            'cvformat_id' =>  $cv_format->name,
            'cvpricing_id' => $cv_pricing->name,
            'status' => false

        ]);
    }



        public function flutterwaveRedirectLink(Request $request)
        {
        $this->validate($request, [
            'flutter_redirect_callback' => 'required',
            'amount' => 'required|numeric|min:5|max:10000000'
        ], [
            'amount.numeric' => 'The deposit amount must be numeric.',
        ]);

        $flutterwave = new Flutterwave();
        $result = $flutterwave->FlutterwaveRedirectLink($request->flutter_redirect_callback);
        if ($result['status'] === 200) {
            $data = $result['data']['data'];
            $link = $data['link'];

            return $link;
        } else {
            return JSON(400, ['error' => $result['error']], 'Unable to deposit');
        }
        }

    public function verifyFlutterwavePayment($callback, Request $request)
    {

        $flutterwave = new Flutterwave();
        $resp = $flutterwave->verifyFlutterwavePayment($request);
        $status = 'error';
        if ($resp['status'] == 400 || $resp['status'] === 503) {
            $callback = base64_decode($callback) . '?deposit-status=' . $status;
            return redirect()->away($callback);
        }
        try{

            $txref = $resp['data']['data']['txref'];
            $flwref = $resp['data']['data']['flwref'];
            $userRef = Ref::where('val', $txref)->latest()->first();
            $paymentStatus = $resp['data']['status'];
            $chargeResponsecode = $resp['data']['data']['chargecode'];
            $chargeAmount = $resp['data']['data']['amount'];
            $chargeCurrency = $resp['data']['data']['currency'];
            $card = null; //flutterwave stopped returning card along with the transaction.
            // $card = $resp['data']['data']['card'];

            if ($paymentStatus === 'success') {
                if (($chargeResponsecode == '00' || $chargeResponsecode == '0') && ($chargeAmount == $userRef->amount)) {
                    $rate = 3;
                    if ($chargeAmount >= 65000) {
                        $rate = 8;
                    }
                    $amount = $chargeAmount - ($chargeAmount * ($rate / 100));

                    $status = 'success';
                    $this->flutterwaveCompleted($userRef->user_id, $amount, $card, $userRef->val, $flwref);
                } else {
                    DepositModel::where('reference_code', $userRef->val)->update(['status' => 'declined']);

                    Transaction::where('reference_code', $userRef->val)
                        ->where('status', 'declined')
                        ->update(['status' => 'declined']);
                }
            } else {
                $callback = base64_decode($callback) . '?deposit-status=' . $status;

                return redirect()->away($callback);
            }

            $callback = base64_decode($callback) . '?deposit-status=' . $status;

            return redirect()->away($callback);
        }catch(\Exception $exception){
            abort(500, 'Unable to process deposit transaction.');
        }
    }

    public function flutterwaveCompleted($user_id, $amount, $card, $ref, $flwref)
    {

        $user_wallet = UserWallet::where('user_id', $user_id)->get()[0];

        $amount_to_add = [
            'initial_amount' => $user_wallet['actual_amount'],
            'actual_amount' => $amount + $user_wallet['actual_amount'],
        ];


        //Update and add from users wallet
        $add_wallet = UserWallet::where('user_id', $user_id)->update($amount_to_add);

        // Update transaction record when deposit is successful
        $trnx = Transaction::where('reference_code',$ref)->first();
        $trnx->update(['status' => 'successful']);

        //$currency_code = User::findorFail($user_id)->country()->get()[0]->currency_code;

        $converted_amount_to_credit_user = $amount; //CurrencyConversionRate::convert($amount, $currency_code, "NGN");

        DepositModel::where('reference_code', $ref)->update(['status' => 'confirmed', 'deposit_amount' => $converted_amount_to_credit_user, "is_resolved" => true]);
//       $c = WalletHistory::create([
//
//            'uuid' => Str::orderedUuid(),
//            'user_id' => $user_id,
//            'transaction_id' => $trnx->id,
//            'status' => 'received',
//            'current_balance' => $user_wallet['actual_amount'] + $amount,
//            'previous_balance' => $user_wallet['actual_amount'],
//
//        ]);




        // Save users card details
        if ($card) {


            UserCardDetail::create([
                'user_id' => 1,
                'auth' => $card['card_tokens']['0']['embedtoken'],
                'last4' => $card['last4digits'],
                'exp_month' => $card['expirymonth'],
                'exp_yr' => $card['expiryyear'],
                'type' => $card['type'],
                'bank' => 'nill',
            ]);
        }

        // Update users ref
        $ref_update = Ref::where('val', $ref)->update(['status' => 1]);

    }


}
