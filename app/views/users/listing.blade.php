<!--
  Page Name:                       listing.blade.php
  author :		            Nicolas Naresh
  Date:			            June, 03 2014
  Purpose:		            This page has the rows for displaying in users index page and it also can be
                                    used for returning rows ajax search requests
  Table referred:		    users
  Table updated:	            users
  Most Important Related Files:      --
-->
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
          <td><a href="{{ URL::route('userEdit', $user->id) }}" class="btn btn-primary btn-xs normal-button"><span class="glyphicon glyphicon-edit"></span></a>
          <td>&nbsp;&nbsp;</td>
          <td><a href="{{ URL::route('userRemove', $user->id) }}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove-circle"></span></a></td>
        </tr>
      </table>
      
    </td>
  </tr>
@endforeach