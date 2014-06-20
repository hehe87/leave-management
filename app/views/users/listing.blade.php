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
      {{ $user->name }}
    </td>
    <td>
      {{ $user->email }}
    </td>
    <td>
      {{date('h:i A',strtotime($user->inTime))}} / {{date('h:i A',strtotime($user->outTime))}}
    </td>
    <td>
      {{$user->phone}}
    </td>
    <td class="text-center">
      {{ $user->getTotalLeaves() }}
    </td>
    <td class="text-center">
      {{ $user->getRemainingLeaves() }}
    </td>
    <td class="text-center">
      <input class='editable text-center' type="text" value="{{ $user->carry_forward_leaves }}" readonly data-id="{{ TemplateFunction::fakeName($user->id) }}" data-model="{{ TemplateFunction::fakeName('User') }}" data-column="{{ TemplateFunction::fakeName('carry_forward_leaves') }}" data-url="{{ URL::route('base.saveEditable') }}" data-orig="{{ $user->carry_forward_leaves }}"/>
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