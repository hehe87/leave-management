 <h3>Request for {{ TemplateFunction::getFullLeaveTypeName($leave['leave_type']) }}</h3>

   <table>
        <tr>
            <td><strong>Date</strong></td>
            @if( "LONG" == $leave['leave_type'] )
                <td>{{ date('d-M-Y', strtotime($leave['leave_date'])) }} to {{ date('d-M-Y', strtotime($leave['leave_to'])) }}</td>
            @elseif( ("LEAVE" == $leave['leave_type']) || ("CSR"== $leave['leave_type']) || ("FH"== $leave['leave_type']) || ("SH"== $leave['leave_type']) )
                <td>{{ date('d-M-Y', strtotime($leave['leave_date'])) }}</td>
            @endif
        </tr>
        <tr>
            <td><strong>Reason</strong></td>
            <td>{{ $leave['reason'] }}</td>
        </tr>
        @if ( "CSR" == $leave['leave_type'] )
        <tr>
            <td>Time slots for CSR</td>
            <td>&nbsp;</td>
        </tr>
            @foreach ( $csr as $c )
                <tr>
                    <td>From - {{ date('h:i A', strtotime($c['from_time'])) }}</td>
                    <td>To - {{ date('h:i A', strtotime($c['to_time'])) }}</td>
                </tr>
            @endforeach
        @endif
    </table>