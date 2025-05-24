<div class="card">

    <h2><a name="primaryColors">{{ __('Primary Colors') }}</a></h2>

    <p>{{ config('app.name') }} {{ __('comes with a primary colour of') }} <span class="text-primary">#3c8dbc</span></p>
    <p>{{ __('To change this edit') }} <code class="language-php">resources/css/app.css</code> </p>

<pre><code class="language-php">@php echo htmlentities("@theme {
  --color-primary: #3c8dbc;
}
") @endphp
</code></pre>

</div>
