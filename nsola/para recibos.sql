SELECT  
		e.cod_emp,
		e.nombre_completo,
		(case 
		when e.nac = 2 then 'E-'
		else 'V-'  						
		end  + 
		e.ci)as ci,
		n.co_novedad_dia,n.co_novedad_hora,n.num_pres,n.num_contpres,n.num_vac,
		[dbo].[ObtenerFechaCadena] (r.fec_emis)as fec_emis,
		r.reci_num,

		n.comentario,
		isnull(n.monto,0)as monto,
		n.auxi_cha,
		n.auxi_num,
		n.tipo,
		dbo.GetMontoConceptoRecibo('Q024', r.reci_num) as SueldoMensVar,
		isnull(dbo.GetMontoConceptoRecibo('Q040', r.reci_num),0) as nivel,
		dbo.GetMontoConceptoRecibo('Q001', r.reci_num) as Sueldo_diario,
		c.co_conce,
		c.des_conce,

		b.co_ban,
		b.des_ban,
		e.cta_banc1,
		e.fecha_ing,

		d.des_depart,
		d.co_depart,

		co.co_cont,
		co.des_cont,

		gn.fec_ini,
		gn.fec_fin,
		ca.co_cargo,	
		ca.des_cargo,
		dbo.GetMontoNetoPagarRecibo(r.reci_num) as NetoPagar
FROM 
		dbo.snrecibo as r

inner join dbo.snnomi as n
		on(r.reci_num = n.reci_num)

inner join dbo.snconcep as c
		on(c.co_conce = n.co_conce)

inner join dbo.snemple as e
		on(n.cod_emp = e.cod_emp)

inner join dbo.sncont as co
		on(co.co_cont = r.co_cont)

left join dbo.snbanco as b
		on(e.co_ban1 = b.co_ban)

inner join dbo.sndepart as d
		on(d.co_depart = r.co_depart)

inner join dbo.sngennomi as gn
		on(gn.co_cont = r.co_cont)AND(gn.fec_emis = r.fec_emis)

inner join dbo.sncargo as ca
		on(ca.co_cargo = e.co_cargo)

WHERE	
		(co.tip_cont in (1,2,3))AND
		(n.tipo in (1,2,3))AND
		
		r.reci_num = 1

GROUP BY e.cod_emp,	c.co_conce, e.nombre_completo, e.nac, e.ci, n.co_novedad_dia,n.co_novedad_hora,n.num_pres,n.num_contpres,n.num_vac,
r.fec_emis,		r.reci_num,	n.comentario, n.monto,	n.auxi_cha,		n.auxi_num,		n.tipo,e.cod_emp,
			c.des_conce,		b.co_ban,		b.des_ban,		e.cta_banc1,		e.fecha_ing,    
			d.des_depart,		d.co_depart,		co.co_cont,		co.des_cont,		gn.fec_ini,		
			gn.fec_fin,		ca.co_cargo,			ca.des_cargo,		r.reci_num



/*LOS CONCEPTOS QUE DEVUELVAN TIPO 3 RESTAN ES DECIR SE DEBEN COLOCAR CON -*/

select cod_emp, nombre_completo from snemple where status = 'A' --PROFESOR QUE SE LOGUEARA

select r.reci_num, r.fec_emis, g.des_gennomi, 'NOMINA' from snrecibo r inner join sngennomi g on r.co_gennomi = g.co_gennomi

where r.cod_emp = 'A001' and r.co_cont in ('01') and g.estado = 2



FECHA NOMINA PDF
			
			FUNCIONALIDAD 
			PARA CAMBIAR CONTRASEÑA AL MOMENTO DE LOGUEAR
			CAMBIAR LOGO DE FIRMA Y SELLO



select (SUM(monto)*18)/12 from snnomi
where cod_emp = 'A001' AND MONTH(fec_emis) = (MONTH(GETDATE())-1)
and year(fec_emis) = 2024 and tipo IN (1)


select (SUM(monto)*18)/12 from snnomi
where cod_emp = 'A001' AND MONTH(fec_emis) = (MONTH(GETDATE())-1)
and year(fec_emis) = 2024 and tipo IN (1)


1 648 142 553
Anydesk colegio
server2021
Administrador
Sanpedro2014
          


