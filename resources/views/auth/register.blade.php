<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
</head>
<body>
    <h2>Registro de Usuario</h2>

    <form method="POST" action="/register">
        @csrf
        <label>Nombre:</label>
        <input type="text" name="name" required>
        <br>
        <label>Email:</label>
        <input type="email" name="email" required>
        <br>
        <label>Contraseña:</label>
        <input type="password" name="password" required>
        <br>
        <label>Confirmar Contraseña:</label>
        <input type="password" name="password_confirmation" required>
        <br>
        <button type="submit">Registrarse</button>
    </form>

    @if ($errors->any())
        <div style="color: red">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
</body>
</html>
