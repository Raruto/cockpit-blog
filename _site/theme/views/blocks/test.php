<?php
/**
 * How to use:
 *
 * use {{ @render('blocks:test.php') }}             inside parent template
 * use {{  @block('test') }}                        inside child templates
 * use {{    $var = $app-block('test') }}           inside child templates
 * use {{ $output = $app-view('blocks:test.php') }} inside router files
 *
 * @see { Lime/App | LimeExtra/App } for more info about it
 */
?>

{{-- Let's define a custom Lexy block --}}
@start('test')
It works
@end('test')

{{-- Print our custom Lexy block --}}
@block('test')

{{-- Retrieve our custom Lexy block --}}
{% $var = $app->block('test', [ 'print' => false ]); %}

{{-- Print again our custom Lexy block --}}
{{ $var }}

<? /* Let's define another custom Lexy block */ ?>
<?php $app->start('test-2'); ?>
It works (again)
<?php $app->end('test-2'); ?>

<? /* Print again our custom Lexy block */ ?>
<?php $app->block('test-2'); ?>
