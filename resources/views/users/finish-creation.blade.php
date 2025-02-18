<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminer l'inscription</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    @if (session('error'))
    <div class="alert alert-error mt-4">
        {{ session('error') }}
    </div>
@endif

    <div class="container mt-5">
        <h1>Terminer l'inscription</h1>

        <form action="{{ route('user.complete', ['id' => $id]) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="confirm-password" class="form-label">Confirmer le mot de passe</label>
                <input type="password" id="password" name="confirmPassword" class="form-control" required>
            </div>

             {{-- <div class="mb-3">
                <label for="role_id" class="form-label">Rôle</label>
                <select id="role_id" name="role_id" class="form-select" required>
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Utilisateur</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrateur</option>
                </select>
            </div> --}}

            <div class="mb-3">
                <label for="role_id" class="form-label">Rôle</label>
                <select name="role_id" id="role_id" class="form-select" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Confirmer</button>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success mt-4">
            {{ session('success') }}
        </div>
    @endif

</body>
</html>
