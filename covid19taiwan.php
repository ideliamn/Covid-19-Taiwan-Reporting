<?php
$url = file_get_contents('https://api.covid19api.com/dayone/country/taiwan/status/confirmed/live');
$data = json_decode($url, true);
$length = count($data);
$cur_array = $length - 1;
$yes_array = $length - 2;
$date_cur1 = $data[$cur_array]['Date'];
$date_cur2 = new DateTime($date_cur1);
$date_cur3 = $date_cur2->format("d F Y");
$case_cur1 = $data[$cur_array]['Cases'];
$case_yes1 = $data[$yes_array]['Cases'];
$case_gro1 = $case_cur1 - $case_yes1;
$sum_growth = 0;
for ($x = $length - 1; $x >= 0; $x--) {
    for ($x = $length - 1; $x >= 1; $x--) {
        $yesterday = $x - 1;
        $case_current = $data[$x]['Cases'];
        $case_yesterday = $data[$yesterday]['Cases'];
        $case_growth = $case_current - $case_yesterday;
        $sum_growth += $case_growth;
        $avg_growth = $sum_growth / $cur_array;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Covid-19 Taiwan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <div class="jumbotron jumbotron-fluid" style="background-image: url(https://www.cdc.gov.tw/Images/page_img/784556.png); background-size:cover;">
        <div class="container" style="color: black!important;">
            <h1 class="display-4">Taiwan Covid-19 Daily Report</h1>
            <p class="lead">Reporting daily Covid-19 positive cases and growth each day.</p>
        </div>
    </div>
    <div class="container">
        <h3>As for <?= $date_cur3 ?>:</h3>
        <br>
        <div class="row">
            <div class="col-sm-4">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Confirmed cases:</h4>
                    <h1><?= $case_cur1 ?></h1>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Case growth:</h4>
                    <h1><?= $case_gro1 ?></h1>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Case growth average daily:</h4>
                    <h1><?= number_format((float)$avg_growth, 2, '.', ''); ?></h1>
                </div>
            </div>
        </div>

        <hr><br>

        <div class="row">
            <div class="col-sm-6">
                <!-- TABLE -->
                <p style="text-align: center;">Detail case amount per day</p>
                <div class="col-auto">
                    <table class="table table-bordered table-hover" style="text-align: center;">
                        <thead>
                            <tr>
                                <th scope="col">Day</th>
                                <th scope="col">Date</th>
                                <th scope="col">Case amount</th>
                                <th scope="col">Case growth</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- FOR START -->
                            <?php
                            $sum_growth = 0;
                            for ($x = $length - 1; $x >= 0; $x--) {
                                $length_fromone = $x + 1;
                                for ($x = $length - 1; $x >= 1; $x--) {
                                    $yesterday = $x - 1;
                                    $date = $data[$x]['Date'];
                                    $date2 = new DateTime($date);
                                    $date3 = $date2->format("d F Y");
                                    $case_current = $data[$x]['Cases'];
                                    $case_yesterday = $data[$yesterday]['Cases'];
                                    $case_growth = $case_current - $case_yesterday;
                                    $sum_growth += $case_growth;
                                    $avg_growth = $sum_growth / $cur_array;
                                    echo "
                                        <tr>
                                    ";
                                    echo "
                                        <td> $x </td>
                                        <td> $date3 </td>
                                        <td> $case_current </td>
                                        <td> $case_growth </td>
                                        </tr>
                                    ";
                                }
                            }
                            ?>
                            <!-- FOR END -->
                        </tbody>
                    </table>
                </div>
                <!-- TABLE END -->
            </div>
            <hr>
            <div class="col-sm-6">
                <div class="textcontent">
                    <br>
                    <h6>Disease Information</h6>
                    <h5>Coronavirus Disease 2019 (Covid-19)</h5>
                    <hr>
                    <p><b>Introduction</b></p>
                    <p>Coronaviruses are enveloped RNA viruses that are spherical in shape and characterized by crown-like spikes on the surface under an electron microscope, hence the name. This type of virus can be further divided into four subgroups: alpha, beta, gamma, and delta. There are seven human coronavirus strains, including two alpha coronaviruses (HCov-229E and HCoV-NL63), two beta coronaviruses (HCov-HKU1 and HCov-OC43), MERS-CoV, SARS-CoV, and the newly discovered SARS-CoV-2. Coronaviruses are major pathogens in both humans and other animals.</p>
                    <p><b>Known hosts</b></p>
                    <p>Certain birds and mammals can also host the seven human coronavirus strains, including bats (a major source), pigs, cattle, turkeys, cats, dogs and ferrets. Reports of zoonosis (cross-species transmission) are sporadic.</p>
                    <p><b>Transmission</b></p>
                    <p>Most human coronaviruses are the result of infection by direct contact with secretions or droplets, such as from coughing or sneezing. Some infected animals also suffer from having diarrhea, and the virus present in the feces can cause further disease transmission.</p>
                    <p><b>Clinical expression and severity</b></p>
                    <p>In humans, coronaviruses mainly cause symptoms common to respiratory ailments including stuffy nose, runny nose, cough, and fever. In some cases, more serious respiratory disease can follow, including pneumonia. Most affected by coronavirus are children under the age of five. Infections in adults and older people have also been reported, and the disease can also aggravate chronic obstructive pulmonary disease. Death is also possible though the mortality rate is very low.</p>
                    <p>The clinical expression of MERS-CoV and SARS-CoV is more serious than those of other strains of coronavirus. With SARS, for example, 20 percent of patients require intensive care, and the disease has a 10 percent mortality rate.</p>
                    <p>As coronaviruses can cause animals to have gastrointestinal tract symptoms, such as diarrhea, scientists suspect that coronaviruses can cause humans similar illness. However, this hypothesis has yet to be supported with evidence.</p>
                    <p>Some studies indicate that coronaviruses can infect nerve cells and, therefore, could cause such nervous system infections as encephalitis. Other studies have found correlations between coronaviruses and Kawasaki disease, but no concrete evidence has yet been discovered.</p>
                    <br>
                </div>
            </div>
        </div>
        <br><br><br>
    </div>
    <div class="footer" style="text-align: center; background-color:lightgrey; padding-bottom: 50px; padding-top: 20px;">
        <div class="container">
            <p>Made with love,</p>
            <p>by Ohira Shosei's mum</p>
            <img src="https://stat.ameba.jp/user_images/20191014/08/moonright1113/3b/39/j/o1042097514614008717.jpg?caw=800" class="rounded-circle" alt="" style="height: 100px; width: 100px;">
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
</body>

</html>