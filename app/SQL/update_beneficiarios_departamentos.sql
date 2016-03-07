UPDATE beneficiarios.geografico bg 
	SET id_departamento = (
				SELECT id FROM geo.departamentos gd
				WHERE gd.id_provincia = bg.id_provincia
				AND gd.id_departamento = bg.id_departamento
			      );
			      
UPDATE beneficiarios.geografico bg
	SET id_localidad = (
				SELECT gl.id FROM geo.localidades gl
				INNER JOIN geo.departamentos gd ON bg.id_departamento = gd.id::varchar
				WHERE gd.id_provincia = gl.id_provincia
				AND gd.id_departamento = gl.id_departamento
				AND gl.id_localidad = bg.id_localidad				
			      );			      