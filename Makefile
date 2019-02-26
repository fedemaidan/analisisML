shell:
	docker-compose run  admin-panel /bin/bash

start:
	docker-compose up -d

stop:
	docker-compose stop 

build:
	docker-compose build

shell-db:
	docker exec -it analisis_ml_db_1 mysql -usymfony-admin-starter-kit -psymfony-admin-starter-kit symfony-admin-starter-kit

dump-db:
	docker exec -it analisis_ml_db_1 mysqldump -usymfony-admin-starter-kit -psymfony-admin-starter-kit --quick --lock-tables=false symfony-admin-starter-kit > dump.sql

restore-db:
	docker exec -it analisis_ml_db_1 mysql -usymfony-admin-starter-kit -psymfony-admin-starter-kit symfony-admin-starter-kit < dump.sql

publicacion-masiva:
	php app/console ml:publicar:masiva:ebay --archivo=/server/src/AppBundle/Resources/public/publicaciones_1.csv
	
importar-reservas:
	php app/console app:importacion:reservas --archivo=/server/src/AppBundle/Resources/public/reservas.csv

importar-productos:
	php app/console app:importacion:productos --archivo=/server/src/AppBundle/Resources/public/productos.csv
	php app/console app:importacion:productos:extras --archivo=/server/src/AppBundle/Resources/public/productos_extras.csv

update-ratio-shipping:
	php app/console ebay:actualizar:categorias --archivo=/server/src/AppBundle/Resources/public/categorias.csv

update-ml-netbooks:
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1652'
	php app/console productos:update

update-ml-tablets:
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA82085'
	php app/console productos:update

update-ml-musica:
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA2987'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA409810'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA3012'
	php app/console productos:update

update-all: update-ml-netbooks update-ml-tablets update-ml-musica
	php app/console productos:update

productos-revisar:
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA126843'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1870'
	php app/console productos:update
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1659'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1692'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1697'
	php app/console productos:update
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1663'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1658'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA84551'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA401998'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLAMLA1676'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1660'
	php app/console productos:update
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1694'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA8883'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1652'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1651'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA6049'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA7235'
	php app/console productos:update
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA10089'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1693'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA3018'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA3013'
	php app/console productos:update
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA3012'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA2987'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA4611'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA3005'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA11094'
	php app/console productos:update
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA402916'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA3022'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA2997'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA48511'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA3014'
	php app/console productos:update
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1841'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA409415'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA352001'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA409814'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA3698'
	php app/console productos:update
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1012'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA1024'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA3697'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA4633'
	php app/console productos:update
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA49329'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA53243'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA10722'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA32234'
	php app/console productos:update
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA11889'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA18239'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA2916'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA411070'
	php app/console productos:update
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA82086'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA403001'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA91777'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA6750'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA399230'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA401457'
	php app/console ml:actualizar:publicaciones --categoria_ml='MLA74265'
	php app/console productos:update

#limpiar set foreign_key_checks=0; truncate table reserva; truncate table producto; truncate table reserva_audit; truncate table producto_audit; set foreign_key_checks=1;