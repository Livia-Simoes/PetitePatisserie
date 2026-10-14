```mermaid
flowchart TD

A([Inicio]) --> B["Acessar o site"]
B --> C["Visualizar a vitrine"]
C --> D["Escolher um produto"]
D --> E["Adicionar produto ao carrinho"]
E --> F["Visualizar carrinho"]

F --> G{"Deseja remover algum produto?"}

G -->|Sim| H["Remover produto do carrinho"]
H --> F

G -->|Nao| I{"Deseja finalizar o pedido?"}

I -->|Nao| C
I -->|Sim| J{"Esta logado?"}

J -->|Nao| K["Fazer login"]
K --> L["Finalizar pedido"]

J -->|Sim| L

L --> M["Registrar pedido"]
M --> N["Registrar itens do pedido"]
N --> O["Limpar carrinho"]
O --> P["Exibir confirmacao"]
P --> Q([Fim])
