INSERT INTO diccionarios.diccionario values
(11,1,'id_provincia','character(2)','SI','Id que tiene la jurisdicción en el SIRGE.'),
(11,2,'Id_Prestación','integer','SI','Id que la jurisdicción le asigna a la prestación.'),
(11,3,'Codigo_Prestación','character varying(11)','SI','Según PSS. Prácticas complementarias de módulos quirúrgicos: deben reportarse como prestaciones independientes.'),
(11,4,'CUIE_Efector','character(6)','SI','Según tabla de efectoree'),
(11,5,'Fecha_Prestacion','date','SI','Fecha en la que la prestacion fue brindada'),
(11,6,'Apellido_Beneficiario','character varying(100)','SI','Apellido del beneficiario de la prestación.'),
(11,7,'Nombre_Beneficiario','character varying(100)','SI','Nombre del beneficiario de la prestación.'),
(11,8,'Clave_Beneficiario','character varying(16)','SI','Clave de beneficiario de quien recibe la prestación.'),
(11,9,'Benef_Tipo_Documento','character(3)','SI','Tipo de documento de quien recibe la prestación.'),
(11,10,'Benef_Clase_Documento','character(1)','SI','Clase de documento de quien recibe la prestación.'),
(11,11,'Benef_Nro_Documento','character varying(14)','SI','Número de documento de quien recibe la prestación.'),
(11,12,'Sexo','character(1)','SI','Sexo de quien recibe la prestación.'),
(11,13,'Fecha de Nacimiento','date','SI','Fecha de nacimiento de quien recibe la prestación.'),
(11,14,'Valor_Unitario_facturado','numeric(7,2)','SI','Precio unitario al que la prestación fue facturada.'),
(11,15,'Cantidad_facturada','integer','SI','Cantidad de unidades facturadas por esta prestación.'),
(11,16,'Importe_Prestacion_Facturado','numeric(9,2)','SI','Importe total facturado por esta prestación a*b.'),
(11,17,'id_factura','integer','SI','Id que la jurisdicción le asigna a la factura en la que está incluida la prestación.'),
(11,18,'numero_fact','integer','SI','Número de la factura en la que está incluida la prestación.'),
(11,19,'fecha_fact','date','SI','Fecha de generación de la factura en la que está incluida la prestación.'),
(11,20,'Importe_Total_Factura','numeric(9,2)','SI','Importe total de la factura en la que está incluida la prestación. Debe ser igual a la suma de Importe_Prestación_Facturado de todas las prestaciones con el mismo id_factura.'),
(11,21,'fecha_recepcion_fact','date','SI','Fecha de recepción por parte de la UG, independientemente de su recepción previa en otra dependencia del ministerio, de la factura en la que está incluida la prestación.'),
(11,22,'Alta complejidad','character(1)','SI','Si: prestación de alta complejidad según PPS - No: resto.'),
(11,23,'id_liquidacion','integer','SI','Id que la jurisdicción le asigna a la liquidación en la que está incluida la prestación.'),
(11,24,'fecha liquidacion','date','SI','Fecha en la que se generó la liquidación en la que está incluida la prestación.'),
(11,25,'Valor_Unitario_aprobado','numeric(7,2)','SI','Precio unitario al que la prestación fue aprobada por la UG.'),
(11,26,'Cantidad_aprobada','integer','SI','Cantidad de unidades por esta prestación aprobadas por la UG. En caso de que no la UG no apruebe ninguna prestación, este campo debe ser cero.'),
(11,27,'importe_Prestación_Aprobado','numeric(9,2)','SI','Importe total por esta prestación aprobado por la UG c*d.');