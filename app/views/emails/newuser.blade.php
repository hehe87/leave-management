@extends('layouts.email_layout')

@section('content')
    <h1>Hi, {{ $admin_user['name'] }}!</h1>

    <p><h3>A new user has requested for account</h3></p>
    <p>Some of the details are given below</p>
    <table>
        <tr>
            <td>Name</td>
            <td>{{{ $temp_user['name'] }}}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $temp_user['email'] }}</td>
        </tr>
        <tr>
            <td>Click on this link to edit and activate the profile</td>
            <td>{{ URL::to("/users/$temp_user[id]/edit") }}</td>
        </tr>
    </table>
@stop