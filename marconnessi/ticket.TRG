TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`localhost` TRIGGER `aggiorna_data_risposta` BEFORE UPDATE ON `ticket` FOR EACH ROW BEGIN\n  IF NEW.risposta_txt IS NOT NULL AND OLD.risposta_txt IS NULL THEN\n    SET NEW.data_risposta = CURRENT_TIMESTAMP;\n  END IF;\nEND'
sql_modes=524288
definers='root@localhost'
client_cs_names='utf8mb4'
connection_cl_names='utf8mb4_general_ci'
db_cl_names='utf8mb4_general_ci'
created=1748204476335244
