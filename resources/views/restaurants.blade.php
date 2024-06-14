<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurantes</title>
    <style>
        .tab-content {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Gerenciamento de Restaurantes</h1>

    <div class="tabs">
        <button onclick="openTab('add')">Adicionar Restaurante</button>
        <button onclick="openTab('view')">Ver Restaurantes</button>
    </div>

    <div id="add" class="tab-content">
        <h2>Adicionar Restaurante</h2>
        <form action="{{ route('restaurant.store') }}" method="POST">
            @csrf
            <label for="nome">Nome do Restaurante:</label><br>
            <input type="text" id="nome" name="nome" required><br>
            <label for="endereco">Endereço:</label><br>
            <input type="text" id="endereco" name="endereco" required><br><br>
            <button type="submit">Adicionar Restaurante</button>
        </form>
    </div>

    <div id="view" class="tab-content">
        <h2>Lista de Restaurantes</h2>
        <ul>
            @foreach ($restaurantes as $restaurante)
                <li>
                    <strong>{{ $restaurante->nome }}</strong> - {{ $restaurante->endereco }}
                    <form action="{{ route('restaurant.edit', $restaurante->id) }}" method="GET">
                        @csrf
                        <button type="submit">Editar</button>
                    </form>
                    <form action="{{ route('restaurant.destroy', $restaurante->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Excluir</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        function openTab(tabName) {
            var i, tabContent;
            tabContent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }
            document.getElementById(tabName).style.display = "block";
        }
    </script>
</body>
</html>
