```mermaid
classDiagram

class Usuario {
    +int id
    +varchar nome
    +varchar email
    +varchar senha
    +varchar tipo
}

class Produto {
    +int id
    +varchar nome
    +numeric preco
    +varchar imagem
}

class Carrinho {
    +int id
    +int usuario_id
    +int produto_id
    +int quantidade
}

class Pedido {
    +int id
    +int usuario_id
    +numeric total
}

class ItemPedido {
    +int id
    +int pedido_id
    +int produto_id
    +int quantidade
    +numeric preco
}

Usuario "1" --> "0..*" Carrinho : possui
Produto "1" --> "0..*" Carrinho : adicionado
Usuario "1" --> "0..*" Pedido : realiza
Pedido "1" --> "0..*" ItemPedido : possui
Produto "1" --> "0..*" ItemPedido : pertence
