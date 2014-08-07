@foreach ($users as $user)
  <tr>
    <td>
      {{$user->name}}
    </td>
  </tr>
@endforeach