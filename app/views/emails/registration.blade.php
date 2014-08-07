@extends('layouts.email_layout')

@section('content')
    <h1>Hi, {{ $user['name'] }}!</h1>

    <p>Welcome to the Leave Management System.</p>
    <p>Click on the link below to set a password for your account</p>
    <table>
        <tr>
            <td>Email</td>
            <td>{{{ $user['email'] }}}</td>
        </tr>
        <tr>
            <td>In/Out Time</td>
            <td>{{{ date('h:i A', strtotime($user['inTime'])) }}} to {{{ date('h:i A', strtotime($user['outTime'])) }}}</td>
        </tr>
        <tr>
            <td>Click on this link</td>
            <td>{{ URL::to('/password/change/'.$token) }}</td>
        </tr>
    </table>
@stop