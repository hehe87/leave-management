@foreach ($users as $user)
  <tr>
    <td>
      {{$user->name}}
    </td>
    <td>
      {{$user->email}}
    </td>
    <td>
      {{$user->phone}}
    </td>
    <td class="text-center">
      {{$user->totalLeaves}}
    </td>
    <td class="text-center">
      -
    </td>
    <td align="center">
      <table>
        <tr>
          <td><a href="{{ URL::route('userEdit', $user->id) }}" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit"></span></a>
          <td>&nbsp;&nbsp;</td>
          <td><a href="{{ URL::route('userRemove', $user->id) }}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove-circle"></span></a></td>
        </tr>
      </table>
      
    </td>
  </tr>
@endforeach