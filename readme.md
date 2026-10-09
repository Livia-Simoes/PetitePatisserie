```mermaid
erDiagram
produtos {
    integer id PK
    varchar(100) nome
    numeric(10,2) preco
    varchar(255) imagem
}

carrinho {
    integer id PK
    integer usuario_id FK
    integer produto_id FK
    integer quantidade
}

pedidos {
    integer id PK
    integer usuario_id FK
    numeric(10,2) total
}

itens_pedido {
    integer id PK
    integer pedido_id FK
    integer produto_id FK
    integer quantidade
    numeric(10,2) preco
}

usuarios {
    integer id PK
    varchar(255) nome
    varchar(100) email
    varchar(255) senha
    varchar(20) tipo
}

usuarios ||--o{ carrinho : possui
produtos ||--o{ carrinho : contido_em

usuarios ||--o{ pedidos : realiza
pedidos ||--|{ itens_pedido : contem
produtos ||--o{ itens_pedido : incluido_em