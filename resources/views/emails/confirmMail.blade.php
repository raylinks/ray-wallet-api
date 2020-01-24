@extends('emails.main')

@section('content')

<table width="100%" cellpadding="0" cellspacing="0"
    style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block"
            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top;
            background-color: #2D9CDB;
            text-align: center;
            border-radius: 10px;
            margin-left: 10%;
            margin-right: 10%;
            color: geeen;"
            valign="top">
            {{--  Hi <b>{{ $username }}</b>, Welcome to Patricia.  --}}
            <h3 style="font-size:22px">Welcome to Raybaba.</h3>
        </td>
    </tr>
    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block"
            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
            valign="top">
            <br>
            {{--  <p style="">Hi <b>alloyking1</b>, Welcome to Patricia.</p>  --}}
            Hi <b>{{ $username }}</b>,
            <br>
            <br>
            We may need to send you critical information about our service and it is important that we have an accurate email address.

            <br>
            <p>Click on the button below to confirm your email address.</p>
        </td>
    </tr>
    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block"
            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
            valign="top">
            <center>
                <a href="{{ $verify_email_link }}" class="btn-primary"
                    style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #5fbeaa; margin: 0; border-color: #5fbeaa; border-style: solid; border-width: 10px 20px;">Confirm Email Address</a>
            </center>

        </td>
    </tr>
    <tr style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td class="content-block"
            style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px; float: right"
            valign="top">
            Patricia Admin.
        </td>
    </tr>
</table>

@endsection
