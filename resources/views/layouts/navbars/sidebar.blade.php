<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="/" class="simple-text logo-normal">
      {{ env('APP_NAME') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'alunos' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('alunos') }}">
          <i class="material-icons">people</i>
            <p>{{ __('alunos') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'turmas' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('turmas') }}">
          <i class="material-icons">supervised_user_circle</i>
            <p>{{ __('turmas') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>