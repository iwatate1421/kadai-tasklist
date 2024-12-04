@if (Auth::check())
    {{-- ユーザー一覧ページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('users.index') }}">ユーザ一覧</a></li>
    {{-- ユーザー詳細ページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('users.show', Auth::user()->id) }}">{{ Auth::user()->name }}&#39;s profile</a></li>
    <li class="divider lg:hidden"></li>
    {{-- ログアウトへのリンク --}}
    <li>
        <a class="link link-hover" href="#" 
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">ログアウト</a>
    </li>
    <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display:none;">
        @csrf
    </form>
@else
    {{-- ユーザー登録ページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('register') }}">ユーザ登録</a></li>
    <li class="divider lg:hidden"></li>
    {{-- ログインページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('login') }}">ログイン</a></li>
@endif