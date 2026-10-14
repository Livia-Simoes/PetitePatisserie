```mermaid
flowchart LR

Cliente["Cliente"]
Admin["Administrador"]

UC01(["Realizar Cadastro"])
UC02(["Fazer Login"])
UC03(["Visualizar Produtos"])
UC04(["Pesquisar Produtos"])
UC05(["Adicionar Produto ao Carrinho"])
UC06(["Visualizar Carrinho"])
UC07(["Remover Produto do Carrinho"])
UC08(["Finalizar Pedido"])

UC09(["Cadastrar Produto"])
UC10(["Atualizar Produto"])
UC11(["Excluir Produto"])
UC12(["Consultar Usuários"])
UC13(["Gerenciar Produtos"])

Cliente --- UC01
Cliente --- UC02
Cliente --- UC03
Cliente --- UC04
Cliente --- UC05
Cliente --- UC06
Cliente --- UC07
Cliente --- UC08

Admin --- UC02
Admin --- UC03
Admin --- UC09
Admin --- UC10
Admin --- UC11
Admin --- UC12
Admin --- UC13
