```mermaid
erDiagram
    USUARIOS {
        int id PK
        varchar nome
        varchar email UK
        varchar senha
        varchar tipo
    }

    PRODUTOS {
        int id PK
        varchar nome
        numeric preco
        varchar imagem
    }

    CARRINHO {
        int id PK
        int usuario_id FK
        int produto_id FK
        int quantidade
    }

    PEDIDOS {
        int id PK
        int usuario_id
        numeric total
    }

    ITENS_PEDIDO {
        int id PK
        int pedido_id
        int produto_id
        int quantidade
        numeric preco
    }

    USUARIOS ||--o{ CARRINHO : possui
    PRODUTOS ||--o{ CARRINHO : adicionado
    USUARIOS ||--o{ PEDIDOS : realiza
    PEDIDOS ||--o{ ITENS_PEDIDO : contem
    PRODUTOS ||--o{ ITENS_PEDIDO : faz_parte
