# Atualização de estados e municípios com API do IBGE

- Código simplificado para consultar e atualizar automaticamente as tabelas de estados e municípios. Ideal para ser integrado em um cron job, permitindo que você mantenha seus dados sempre atualizados de forma eficiente e automática.

## Tabelas necessárias para funcionamento das funções

```sql
-- Tabela para gravar os estados
CREATE TABLE estados (
  estados_id int(11) NOT NULL AUTO_INCREMENT,
  estados_codigo int(11) DEFAULT NULL,
  estados_uf varchar(45) DEFAULT NULL,
  estados_nome varchar(100) DEFAULT NULL,
  estados_data_atualizacao timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (estados_id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Tabela para gravar os municípios
CREATE TABLE municipios (
  municipios_id int(11) NOT NULL AUTO_INCREMENT,
  municipios_codigo int(11) DEFAULT NULL,
  municipios_nome varchar(100) DEFAULT NULL,
  municipios_uf_codigo int(11) DEFAULT NULL,
  municipios_uf varchar(45) DEFAULT NULL,
  municipios_data_atualiza timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (municipios_id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
