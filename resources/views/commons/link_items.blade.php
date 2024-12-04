@if (Auth::check())
    {{-- ユーザー一覧ページへのリンク --}}
    <li><a class="link link-hover" href="#">Users</a></li>
    {{-- ユーザー詳細ページへのリンク --}}
    <li><a class="link link-hover" href="#">{{ Auth::user()->name }}&#39;s profile</a></li>
    <li class="divider lg:hidden"></li>
    {{-- ログアウトへのリンク --}}
    <li><a class="link link-hover" href="#" onclick="event.preventDefault();this.closest('form').submit();">ログアウト</a></li>
@else
    {{-- ユーザー登録ページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('register') }}">ユーザ登録</a></li>
    <li class="divider lg:hidden"></li>
    {{-- ログインページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('login') }}">ログイン</a></li>
@endif