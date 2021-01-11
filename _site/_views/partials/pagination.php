<?php
$page_num  = $pagination['page_num'] ?? 1;
$num_rows  = $pagination['num_rows'] ?? 1;
$per_page  = $pagination['per_page'] ?? 1;

$url       = $app['base_url'] . ($pagination['page_slug'] ?? '') . '/';

$adjacents = $pagination['adjacents'] ?? 3;

$prev      = $page_num - 1;
$next      = $page_num + 1;
$last      = $per_page > 0 ? ceil( $num_rows / $per_page ) : 1;

?>
<nav class="pagination">
	<ul>
		@if ( $last > 1 )
			{{-- PREVIOUS page. --}}
			@if ( $prev > 0 )
				<li><a href="{{ $url . $prev }}">&laquo;</a></li>
			@endif

			@if ( $last < 7 + ( $adjacents * 2 ) )
				<?php for ( $i = 1; $i <= $last; $i++ ) : ?>
					<li><a href="{{ $url . $i }}"{{ ($i === $page_num ? ' class="active"' : '') }}>{{ $i }}</a></li>
				<?php endfor ?>
			@elseif ( $last > 5 + ( $adjacents * 2 ) )
				{{-- CLOSE TO BEGINNING: hide only later pages. --}}
				@if ( $page_num < 1 + ( $adjacents * 2 ) )
					<?php for ( $i = 1; $i < 4 + ( $adjacents * 2 ); $i++ ) : ?>
						<li><a href="{{ $url . $i }}"{{ ($i === $page_num ? ' class="active"' : '') }}>{{ $i }}</a></li>
					<?php endfor; ?>
					<li>...</li>
					<li><a href="{{ $url . ($last - 1) }}">{{ ($last - 1) }}</a></li>
					<li><a href="{{ $url . $last }}">{{ $last }}</a></li>
				{{-- IN THE MIDDLE: hide some front and some back. --}}
				@elseif ( $page_num > ( $adjacents * 2 ) && $page_num < $last - ( $adjacents * 2 ) )
					<li><a href="{{ $url }}1">1</a></li>
					<li><a href="{{ $url }}2">2</a></li>
					<li>...</li>
					<?php for ( $i = $page_num - $adjacents; $i <= $page_num + $adjacents; $i++ ) : ?>
						<li><a href="{{ $url . $i }}"{{ ($i === $page_num ? ' class="active"' : '') }}>{{ $i }}</a></li>
					<?php endfor; ?>
					<li>...</li>
					<li><a href="{{ $url . ($last - 1) }}">{{ ($last - 1) }}</a></li>
					<li><a href="{{ $url . $last }}">{{ $last }}</a></li>
				{{-- CLOSE TO END: hide only early pages. --}}
				@else
					<li><a href="{{ $url }}1">1</a></li>
					<li><a href="{{ $url }}2">2</a></li>
					<li>...</li>
					<?php for ( $i = $last - ( 2 + ( $adjacents * 2 ) ); $i <= $last; $i++ ) : ?>
						<li><a href="{{ $url . $i }}"{{ ($i === $page_num ? ' class="active"' : '') }}>{{ $i }}</a></li>
					<?php endfor; ?>
				@endif
			@endif

			{{-- NEXT page. --}}
			@if ( $next <= $last )
				<li><a href="{{ $url . $next }}">&raquo;</a></li>
			@endif
		@endif
	</ul>
</nav>
