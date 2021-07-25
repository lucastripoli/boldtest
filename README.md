# Projeto Bold test

projeto criado em drupal 8 e lando v3.1.4

# Guia para inicializar o projeto (linux)

- Instale o Lando na versão recomendada conforme (https://docs.lando.dev/basics/installation.html)
- Rode o comando "lando start"
- Na pasta do projeto rode o comando "lando drush sql-cli < backup.sql"
- rode o comando "lando drush cr"
- Acesse o site pela URL http://bold-test.lndo.site/

OBS:validar se senhum outro projeto está utilizando as portas padrão do lando.

# Paginas

#### Parte1 - new content - http://bold-test.lndo.site/admin/structure/types
Adicionei um field de imagem e um hook que no momento de salvar o node salva um arquivo de imagem e grava no field do conteudo.

#### Parte1 - new view - http://bold-test.lndo.site/doglist
Criei uma view simples que carrega os dados do content type

#### Parte2 - New Configuration page - http://bold-test.lndo.site/admin/config/select_dog
Simples form de configuração

#### Parte2 - New Custom Block - is a block in the sidebar first
Nesse bloco a configuração anterior é utilizada para carregar o path da imagem na API no cache do drupal 

#### Pagina extra - Pagina de configuração da URL da API - http://bold-test.lndo.site/admin/config/get_url

# Notas

Algumas boas praticas foram ignoradas para facilitar a abertura do projeto, São elas:

 - Banco de dados no repositorio (poderia ser feito com migrations API)
 - vendor e core no repositorio.
 - Site files no repositorio.
 - eliminar o arquivo de imagem quando o mesmo não é mais utilizado no node / bloco
 - Falta de um thema proprio.(não vi necessidade já que os temas não seriam avaliados)

# codigo python para carregar as raças dos cães

import requests
import json

r = requests.get('https://dog.ceo/api/breeds/list/all')
breeds_json = json.loads(r.text)


print(type(breeds_json['message']))

for breed, breed_value in breeds_json['message'].items():
	if breed_value != []:
		for secont_part in breed_value:
			print(breed+"/"+secont_part+"|"+breed+"-"+secont_part)
	else:
		print(breed)

