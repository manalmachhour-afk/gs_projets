<x-guest-layout>
    <div class="lg-page">
        <div class="lg-blob lg-blob-1"></div>
        <div class="lg-blob lg-blob-2"></div>

        <div class="lg-wrap">

            {{-- Logo + titre --}}
            <div class="lg-head">
                <div class="lg-logo">
                    <img src="/logo.jpg" alt="Logo de l'entreprise">
                </div>
                <h1>Connexion</h1>
                <p>Accédez à votre espace</p>
            </div>

            {{-- Carte --}}
            <div class="lg-card">

                @if (session('status'))
                    <div class="lg-status">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    {{-- Email --}}
                    <div class="lg-field">
                        <label for="email">Adresse email</label>
                        <div class="lg-input">
                            <svg class="lg-ico" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}"
                                   required autofocus autocomplete="username" placeholder="vous@exemple.com"
                                   class="{{ $errors->has('email') ? 'has-error' : '' }}">
                        </div>
                        @error('email') <div class="lg-error">{{ $message }}</div> @enderror
                    </div>

                    {{-- Mot de passe --}}
                    <div class="lg-field">
                        <div class="lg-row">
                            <label for="password">Mot de passe</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="lg-link">Oublié ?</a>
                            @endif
                        </div>
                        <div class="lg-input">
                            <svg class="lg-ico" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                            <input id="password" type="password" name="password"
                                   required autocomplete="current-password" placeholder="••••••••"
                                   class="{{ $errors->has('password') ? 'has-error' : '' }}">
                            <button type="button" id="togglePwd" class="lg-eye" aria-label="Afficher le mot de passe">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password') <div class="lg-error">{{ $message }}</div> @enderror
                    </div>

                    {{-- Se souvenir de moi --}}
                    <label class="lg-remember" for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Se souvenir de moi</span>
                    </label>

                    {{-- Bouton --}}
                    <button type="submit" class="lg-btn" id="loginBtn">Se connecter</button>
                </form>
            </div>

            @if (Route::has('register'))
                <p class="lg-register">
                    Pas encore de compte ?
                    <a href="{{ route('register') }}" class="lg-link">Créer un compte</a>
                </p>
            @endif
        </div>
    </div>

    <style>
        .lg-page {
            position: relative; overflow: hidden;
            min-height: 100vh; width: 100%;
            display: flex; align-items: center; justify-content: center;
            padding: 24px 16px; box-sizing: border-box;
            background: #f8fafc;
            font-family: 'Poppins', 'Segoe UI', Arial, sans-serif;
        }
        .lg-page *, .lg-page *::before, .lg-page *::after { box-sizing: border-box; }

        .lg-blob { position: absolute; width: 300px; height: 300px; border-radius: 50%; filter: blur(60px); pointer-events: none; }
        .lg-blob-1 { top: -90px; left: -90px; background: rgba(196,181,253,.5); }
        .lg-blob-2 { bottom: -90px; right: -90px; background: rgba(165,180,252,.5); }

        .lg-wrap { position: relative; width: 100%; max-width: 380px; }

        /* En-tête */
        .lg-head { text-align: center; margin-bottom: 16px; }
        .lg-logo {
            width: 64px; height: 64px; margin: 0 auto 8px;
            border-radius: 50%; background: #fff; padding: 6px;
            box-shadow: 0 4px 12px rgba(79,70,229,.2);
            border: 2px solid #ede9fe; overflow: hidden;
        }
        .lg-logo img { width: 100%; height: 100%; object-fit: contain; border-radius: 50%; display: block; }
        .lg-head h1 { margin: 0; font-size: 1.15rem; font-weight: 700; color: #111827; }
        .lg-head p  { margin: 2px 0 0; font-size: .8rem; color: #6b7280; }

        /* Carte */
        .lg-card {
            background: #fff; border-radius: 16px; padding: 24px;
            box-shadow: 0 12px 30px -10px rgba(79,70,229,.3);
            border: 1px solid #f1f5f9;
        }
        .lg-status { background: #dcfce7; color: #15803d; font-size: .82rem; padding: 8px 12px; border-radius: 8px; margin-bottom: 14px; }

        /* Champs */
        .lg-field { margin-bottom: 14px; }
        .lg-field label, .lg-row label { display: block; font-size: .78rem; font-weight: 600; color: #374151; margin-bottom: 4px; }
        .lg-row { display: flex; justify-content: space-between; align-items: center; }
        .lg-row label { margin-bottom: 4px; }

        .lg-input { position: relative; }
        .lg-input input {
            display: block; width: 100%; height: 40px;
            padding: 0 40px 0 36px;
            font-size: .88rem; color: #111827;
            background: #f9fafb; border: 1.5px solid #e5e7eb; border-radius: 10px;
            outline: none; transition: all .15s;
        }
        .lg-input input:focus { background: #fff; border-color: #7c3aed; box-shadow: 0 0 0 3px rgba(124,58,237,.15); }
        .lg-input input.has-error { border-color: #f87171; }
        .lg-ico { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; pointer-events: none; }
        .lg-eye {
            position: absolute; right: 0; top: 0; height: 100%; width: 40px;
            display: flex; align-items: center; justify-content: center;
            background: none; border: none; color: #9ca3af; cursor: pointer; padding: 0;
        }
        .lg-eye:hover { color: #7c3aed; }
        .lg-error { color: #dc2626; font-size: .75rem; margin-top: 4px; }

        /* Divers */
        .lg-link { color: #7c3aed; font-size: .78rem; font-weight: 500; text-decoration: none; }
        .lg-link:hover { color: #5b21b6; text-decoration: underline; }
        .lg-remember { display: flex; align-items: center; gap: 8px; margin-bottom: 16px; cursor: pointer; }
        .lg-remember input { width: 15px; height: 15px; accent-color: #7c3aed; margin: 0; }
        .lg-remember span { font-size: .78rem; color: #4b5563; }

        /* Bouton */
        .lg-btn {
            display: block; width: 100%; height: 42px;
            border: none; border-radius: 10px; cursor: pointer;
            font-size: .9rem; font-weight: 600; color: #fff;
            background: linear-gradient(135deg, #6d28d9, #4f46e5);
            box-shadow: 0 6px 14px -4px rgba(79,70,229,.5);
            transition: transform .15s, box-shadow .15s, opacity .15s;
        }
        .lg-btn:hover { transform: translateY(-1px); box-shadow: 0 10px 18px -4px rgba(79,70,229,.55); }
        .lg-btn:disabled { opacity: .7; cursor: not-allowed; transform: none; }

        .lg-register { text-align: center; margin: 14px 0 0; font-size: .8rem; color: #6b7280; }
        .lg-register .lg-link { font-size: .8rem; font-weight: 600; }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var pwd = document.getElementById('password');
            document.getElementById('togglePwd').addEventListener('click', function () {
                pwd.type = pwd.type === 'password' ? 'text' : 'password';
            });
            document.getElementById('loginForm').addEventListener('submit', function () {
                var btn = document.getElementById('loginBtn');
                btn.disabled = true;
                btn.textContent = 'Connexion…';
            });
        });
    </script>
</x-guest-layout>
