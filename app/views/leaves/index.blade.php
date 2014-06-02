@if( $message = Session::get('message') )
{
	{{ $message }}
}
@endif