<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Publicity;
use Braintree;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function select(Apartment $apartment)
    {
        $publicities = Publicity::all();
        //dd($publicities);
        //dd($publicities, $apartment);
        return view('admin.publicity.index', compact('publicities', 'apartment'));
    }

    public function take(Apartment $apartment, Publicity $publicity)
    {
        /* $apartments = Apartment::all(); */
        $gateway = new Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        $token = $gateway->ClientToken()->generate();
        //dd($publicity, $apartment, $token);
        return view('admin.publicity.edit', compact('apartment', 'publicity', 'token'));
    }

    public function checkout(Request $request, Apartment $apartment, Publicity $publicity)
    {
        //dd($request->all());
        $gateway = new Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);
        $amount = $request->amount;
        $nonce = $request->payment_method_nonce;

        $resultCustomer = $gateway->customer()->create([
            'email' => Auth::user()->email,
        ]);
        //dd($resultCustomer->customer->id);
        $customerId = $resultCustomer->customer->id;

        $resultCreate = $gateway->paymentMethod()->create([
            'customerId' => $customerId,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'verifyCard' => true,
            ]
        ]);

        //dd($resultCreate);

        if ($resultCreate->success) {
            $result = $gateway->transaction()->sale([
                'amount' => $amount,
                'paymentMethodNonce' => $nonce,
                'options' => [
                    'submitForSettlement' => true
                ]
            ]);
            $expirationDate = Carbon::now('Europe/Rome')->addHours($publicity->duration);
            $currentDate = Carbon::now('Europe/Rome');
            //dd($expirationDate, $publicity->duration, $currentDate);
            //dd($currentDate);
            // $apartment->publicities()->sync($request->publicities);zz
            $publicities = $apartment->publicities()->get();
            //dd($publicities);
            if (count($publicities) > 0) {
                //dd('esiste gia la pubblicità per questo appartamento');
                // get publicity with max expiration_date
                $allDates = [];
                foreach ($publicities as $apt_publicity) {
                    array_push($allDates, $apt_publicity->pivot->publicity_expiration_date);
                }
                $lastDate = max($allDates);
                //check if is already active
                if (Carbon::parse($lastDate) > $currentDate) {

                    foreach ($publicities as $apt_publicity) {
                        // if ex_date is > of current date
                        if ($apt_publicity->pivot->publicity_expiration_date === $lastDate) {
                            // hours differences
                            $hours = Carbon::parse($apt_publicity->pivot->publicity_expiration_date);
                            $leftHours = $hours->diffInMinutes($currentDate);

                            //Update expired date with remain hours
                            $updateExpirationDate = $expirationDate->addMinutes($leftHours);

                            // save and break loop
                            $publicity->apartments()->attach($apartment->id, ['publicity_start_date' => $currentDate, 'publicity_expiration_date' => $updateExpirationDate]);
                            return redirect()->route('admin.apartment.index')->with('message', "Sponsorizzazione di \"$apartment->title\" avvenuta con successo");
                        }
                    }
                } else {
                    $publicity->apartments()->attach($apartment->id, ['publicity_start_date' => $currentDate, 'publicity_expiration_date' => $expirationDate]);
                }
            } else {
                //dd('1 pubblicità');
                $publicity->apartments()->attach($apartment->id, ['publicity_start_date' => $currentDate, 'publicity_expiration_date' => $expirationDate]);
            }
            return redirect()->route('admin.apartment.index')->with('message', "Sponsorizzazione di \"$apartment->title\" avvenuta con successo");
        } else {
            return redirect()->back()->with('message', "La transazione non è stata accettata. Si prega di riprovare con una carta valida");
        }
    }
}