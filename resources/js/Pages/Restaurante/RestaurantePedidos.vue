<template>
    <div>
      <div v-for="(restaurante, index) in restaurantes" :key="restaurante.id" class="card">
        <div class="card-header bg-white dark:bg-gray-800" @click="togglePedidos(index)">
          <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ restaurante.nome }}
          </h2>
          <span v-if="mostrarPedidos[index]" class="toggle-icon text-gray-700 dark:text-gray-300">
            <i class="fas fa-chevron-up "></i> Mostrar menos
          </span>
          <span v-else class="toggle-icon text-gray-700 dark:text-gray-300">
            <i class="fas fa-chevron-down"></i> Mostrar mais
          </span>
        </div>
        <div v-if="restaurante.imagem" class="card-image">
          <img :src="'storage/restaurantes/' + restaurante.imagem" alt="Restaurante Imagem" />
        </div>
        <div class="card-content" v-show="mostrarPedidos[index]">
          <ul v-if="restaurante.pedidos.length">
            <li
              v-for="pedido in ordenarPedidos(restaurante.pedidos)"
              :key="pedido.id"
              class="pedido-item"
            >
              <p class="text-gray-700 dark:text-gray-300">
                <strong class="text-gray-900 dark:text-gray-100" >Itens:</strong>
                 {{ formatarItens(pedido.itens) }}
              </p>
              <p class="text-gray-700 dark:text-gray-300">
                <strong class="text-gray-900 dark:text-gray-100">Preço Total:</strong>
                {{ pedido.preco_total }}
              </p>
              <p class="text-gray-700 dark:text-gray-300">
                <span class="pedido-data text-gray-700 dark:text-gray-300">{{ formatarData(pedido.created_at) }}</span>
                -
                <span class="pedido-hora text-gray-700 dark:text-gray-300">{{ formatarHora(pedido.created_at) }}</span>
              </p>
            </li>
          </ul>
          <p v-else class="nenhum-pedido text-gray-700 dark:text-gray-300">Nenhum pedido encontrado para este restaurante.</p>
        </div>
      </div>
    </div>
  </template>


<script>
export default {
    props: {
        restaurantes: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            mostrarPedidos: {}, // Objeto para controlar a visibilidade dos pedidos de cada restaurante
        };
    },
    methods: {
        togglePedidos(index) {
            // Alterna a visibilidade dos pedidos do restaurante com o índice fornecido
            this.mostrarPedidos[index] = !this.mostrarPedidos[index];
        },
        formatarItens(itensJson) {
            try {
                const itens = JSON.parse(itensJson);
                return itens.map(item => `${item.nome} (x${item.quantidade})`).join(', ');
            } catch (error) {
                console.error('Erro ao formatar itens:', error);
                return 'Itens inválidos';
            }
        },
        formatarData(dataString) {
            const data = new Date(dataString);
            return data.toLocaleDateString();
        },
        formatarHora(dataString) {
            const data = new Date(dataString);
            return data.toLocaleTimeString();
        },
        ordenarPedidos(pedidos) {
            // Ordena os pedidos por data e hora em ordem decrescente (do mais recente para o mais antigo)
            return [...pedidos].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        },
    },
};
</script>

<style scoped>
.card {
  border: 1px solid #ccc;
  margin-bottom: 20px;
  border-radius: 5px;
  overflow: hidden; /* Para que a imagem não ultrapasse o card */
}

.card-header {
  padding: 15px;
  cursor: pointer;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.card-header h2 {
  margin: 0;
  font-size: 1.2em;
}

.card-image {
  height: 200px; /* Altura fixa para a imagem */
  padding-left: 10px;
  padding-right: 10px;
  padding-bottom: 10px;
}

.card-image img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* Para ajustar a imagem ao container */
}

.card-content {
  padding: 15px;
}

.pedido-item {
  border-bottom: 1px dashed #eee;
  padding: 10px 0;
}

.pedido-item:last-child {
  border-bottom: none;
}

.pedido-data,
.pedido-hora {
  font-size: 0.9em;
}

.nenhum-pedido {
  text-align: center;
  font-style: italic;
}
</style>
