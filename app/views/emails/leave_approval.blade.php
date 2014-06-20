<h3>Hi {{ $requesting_user['name'] }}</h3>

<h5>Your request for {{ TemplateFunction::getFullLeaveTypeName($leave['leave_type']) }} has been {{ $approved_status}}</h5>
Details: <br>

Request for date : {{ date('d-M-Y', strtotime($leave['leave_date'])) }} <br>
    @if("LONG" ==$leave['leave_type'])
        to {{ date('d-M-Y', strtotime($leave['leave_to'])) }}
    @endif
@if( isset($csr) )
    CSR Details
    <table>
        <tr>
        @foreach($csr as $c)
                <td>{{ date('h:i A', strtotime($c['from_time'])) }} To {{ date('h:i A', strtotime($c['to_time'])) }}</td>
        @endforeach
        </tr>
    </table>
@endif
<table>
    @foreach ($approver_users as $approver)
        <tr>
            <td>{{ $approver['name'] }}</td>
            <td>{{ $approver['status'] }}</td>
        </tr>
    @endforeach
</table>