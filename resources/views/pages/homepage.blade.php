@extends('layouts.app')

@section('content')
    <div id="content">
        <div class="inner">

            {{-- Language Selector --}}
            <form method="GET" action="{{ url()->current() }}" style="margin-bottom: 1em;">
                <label for="lang">Translate page:</label>
                <select name="lang" onchange="this.form.submit()">
                    <option value="en" {{ request('lang') == 'en' ? 'selected' : '' }}>English</option>
                    <option value="fr" {{ request('lang') == 'fr' ? 'selected' : '' }}>French</option>
                    <option value="es" {{ request('lang') == 'es' ? 'selected' : '' }}>Spanish</option>
                    <option value="de" {{ request('lang') == 'de' ? 'selected' : '' }}>German</option>
                    <option value="it" {{ request('lang') == 'it' ? 'selected' : '' }}>Italian</option>
                    <option value="lv" {{ request('lang') == 'lv' ? 'selected' : '' }}>Latvian</option>

                </select>
            </form>

            <article class="box post post-excerpt">
                <header>
                    <h2><a href="#">{{ $translated['title1'] ?? 'Welcome to O!TH' }}</a></h2>
                    <p>{{ $translated['subtitle1'] ?? 'O!TH (osu!tournament hub) is a place to find and document osu tournaments.' }}</p>
                </header>
                <div class="info">
                    <span class="date"><span class="month">Jun<span>e</span></span> <span class="day">11</span><span class="year">, 2025</span></span>
                    <ul class="stats">
                        <li><a href="#" class="icon fa-comment">4</a></li>
                        <li><a href="#" class="icon fa-heart">32</a></li>
                        <li><a href="#" class="icon brands fa-twitter">619</a></li>
                        <li><a href="#" class="icon brands fa-facebook-f">65</a></li>
                    </ul>
                </div>
                <a href="#" class="image featured"><img src="{{ asset('images/tournamentpic.png') }}" alt="" /></a>
                <p>{!! $translated['body1a'] ?? "<strong>Hello!</strong> You're looking at <strong>O!TH</strong>, an osu! tournament documentation site by <a href='https://github.com/EBRZ124' target='_blank'>EB124</a> for people of <a href='https://osu.ppy.sh/' target='_blank'>osu!game</a>. Tournament documentation is a field in the community that has been lacking for years. Although external sites like <a href='https://liquipedia.net/' target='_blank'>liquipedia</a> exist, it's much broader than what O!TH aims to be." !!}</p>
                <p>{!! $translated['body1b'] ?? "You can sign up and comment under documented tournaments <a href='http://osu.ppy.sh' target='_blank'>here</a>. Trusted members can apply for 'verified' user status, which will allow you to not just view and comment under posts, but also make ones yourself. If you want to join the team, feel free to shoot an application to <a href='https://github.com/EBRZ124' target='_blank'>my contacts</a>." !!}</p>
            </article>

            <article class="box post post-excerpt">
                <header>
                    <h2><a href="#">{{ $translated['title2'] ?? 'OWC 2024' }}</a></h2>
                    <p>{{ $translated['subtitle2'] ?? 'osu! tournament of the decade...' }}</p>
                </header>
                <div class="info">
                    <span class="date"><span class="month">Dec<span>ember</span></span> <span class="day">12</span><span class="year">, 2024</span></span>
                    <ul class="stats">
                        <li><a href="#" class="icon fa-comment">16</a></li>
                        <li><a href="#" class="icon fa-heart">32</a></li>
                        <li><a href="#" class="icon brands fa-twitter">64</a></li>
                        <li><a href="#" class="icon brands fa-facebook-f">128</a></li>
                    </ul>
                </div>
                <a href="#" class="image featured"><img src="{{ asset('images/owv2024image.jpg') }}" alt="" /></a>
                <p>{{ $translated['body2'] ?? 'For over half a decade, the United States team had dominated the biggest international stage. However, the beasts that are South Korean decided to put a stop to the unbeatable and probably unrepeatable streak.' }}</p>
            </article>

            <div class="pagination">
                <div class="pages">
                    <a href="" class="active">1</a>
                    <a href="archives">2</a>
                </div>
                <a href="archives" class="button next">Next Page</a>
            </div>

        </div>
    </div>
@endsection
