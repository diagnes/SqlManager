<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SQL Manager</title>
    <link rel="stylesheet" href="css/bootstrap1.min.css">
    <link rel="stylesheet" href="css/global.css">
</head>
<body>
<div class="sd_header">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-0">
                <div class="block">
                    <h1>Welcome to the Sql Manager</h1>
                    <p>Retrouver toute les données dont vous avez besoin de A - Z</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 col-lg-offset-3 col-md-offset-3 col-sm-offset-0">
            <div class="my-form">
                <form class="request-form">
                    <div class="form-group">
                        <label for="request">BDD</label>
                        <select id="bdd" name="bdd" class="form-control">
                            <option>Aucune</option>
                        </select>
                    </div>
                    <div class="form-group hide">
                        <label for="request">Table</label>
                        <div class="table-disp"></div>
                    </div>
                    <div class="form-group">
                        <label for="request">Votre requete</label>
                        <textarea id="request" name="request" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block request">Envoyer</button>
                    </div>
                </form>
                <div class="alert alert-danger hide db" role="alert">
                    <strong>Error:</strong> <span class="my-error"></span>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="request-data"></div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="history"></div>
            <div class="alert alert-danger hide historique" role="alert">
                <strong>Error:</strong> <span class="my-error"></span>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>