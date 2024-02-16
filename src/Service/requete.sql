INSERT INTO article (num_article,designation,prix_unitaire) VALUES
(000001, 'fanta', 3.50),
(000002, 'coca', 2.50),
(000003, 'mangue', 1.50),
(000004, 'orange', 0.50),
(000005, 'citron', 1.00);


INSERT INTO client (num_Client, nom_Client, adresse_Client) VALUES
('CL00001','ibra','lyon'),
('CL00002','jean','bordeaux'),
('CL00003','amine','paris'),
('CL00004','mohamed','marseille'),
('CL00005','kanté','lille'),
('CL00006','fafa','sarlat'),
('CL00007','loulou','bergerac'),
('CL00008','medi','pau');

INSERT INTO commande (num_Commande, client_id) VALUES
('C00001',1),
('C00001',2),
('C00002',3),
('C00003',4),
('C00004',5);