<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\User;
use Mail;
use Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm()
      {
         return view('auth.forgot-password');
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
          ]);

          $existingToken = DB::table('password_reset_tokens')->where('email', $request->email)->first();

          if ($existingToken) {
              // Update existing token
              $token = $existingToken->token;
          } else {
              // Generate new token
              $token = Str::random(64);

              DB::table('password_reset_tokens')->insert([
                  'email' => $request->email,
                  'token' => $token,
                  'created_at' => Carbon::now()
              ]);
          }

          Mail::to($request->email)->send(new ForgotPasswordMail($token));

          return back()->with('success', 'Kami telah mengirimkan tautan pengaturan ulang kata sandi Anda melalui email!');
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) {
         return view('auth.forgetPasswordLink', ['token' => $token]);
      }

      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);

          $updatePassword = DB::table('password_reset_tokens')
                              ->where([
                                'email' => $request->email,
                                'token' => $request->token
                              ])
                              ->first();

          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }

          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);

          DB::table('password_reset_tokens')->where(['email'=> $request->email])->delete();
          return redirect('/login')->with('success', 'Kata sandi Anda telah diubah!');
      }
}
