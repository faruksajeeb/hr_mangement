<table class="table_earning" style="border:none !important; width:100%"  cellspacing="0" cellpadding="0" >
    <tr>
        <td class="accor_label">Basic:</td>
        <td class="accor_value">
            <?php
           // print_r($paySlip);
            $basicSalary = $paySlip->basic;
            echo number_format($basicSalary);
            ?>
        </td>
    </tr>
    <tr>
        <td class="accor_label">House Rent:</td>
        <td class="accor_value">
            <?php
            $houseRentAllowance = $paySlip->hra;
            echo number_format($houseRentAllowance);
            ?>
        </td>
    </tr>
    <tr>
        <td class="accor_label">Medical Allow.:</td>
        <td class="accor_value">
            <?php
            $medicalAllowance = $paySlip->ma;
            echo number_format($medicalAllowance);
            ?>
        </td>
    </tr>
    <tr>
        <td class="accor_label">Transport Allow.:</td>
        <td class="accor_value">
        <?php
        $transportAllowance = $paySlip->ta;
        echo number_format($transportAllowance);
        ?>
        </td>
    </tr>
    <tr>
        <td class="accor_label">Mobile/Telephone Allow.:</td>
        <td class="accor_value"><?php echo number_format($paySlip->mba); ?></td>
    </tr>
    <tr>
        <td class="accor_label">P.F Allow.:</td>
        <td class="accor_value"><?php echo number_format($paySlip->pfa); ?></td>
    </tr>
    
    <tr>
        <td class="accor_label">Conveyance Allow.:</td>
        <td class="accor_value"><?php echo number_format($paySlip->ca); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Arear:</td>
        <td class="accor_value"><?php echo number_format($paySlip->arear); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Telephone Allow.:</td>
        <td class="accor_value"><?php echo number_format($paySlip->telephone_allow); ?></td>
    </tr>
    
    <tr>
        <td class="accor_label">Over Time:</td>
        <td class="accor_value"><?php echo number_format($paySlip->ot_taka); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Other Allow.:</td>
        <td class="accor_value"><?php echo number_format($paySlip->oa); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Entertainment Allow.:</td>
        <td class="accor_value"><?php echo number_format($paySlip->ea); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Gratuity:</td>
        <td class="accor_value"><?php echo number_format($paySlip->gratuity); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Performance Bonus:</td>
        <td class="accor_value"><?php echo number_format($paySlip->pb); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Special Bonus:</td>
        <td class="accor_value"><?php echo number_format($paySlip->bonus); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Festival Bonus:</td>
        <td class="accor_value"><?php
$festivalBonus = $paySlip->festival_bonus;
echo number_format($festivalBonus);
?></td>
    </tr>
    <tr>
        <td class="accor_label">incentive:</td>
        <td class="accor_value"><?php echo number_format($paySlip->incentive); ?></td>
    </tr>
    <tr>
        <td class="accor_label">Arrear PF:</td>
        <td class="accor_value"><?php echo number_format($paySlip->arrear_pf); ?></td>
    </tr>
    <tr>
        <td class="accor_label">House M. Allow.:</td>
        <td class="accor_value"><?php echo number_format($paySlip->hma); ?></td>
    </tr>
    <tr>
        <td class="accor_label">PF:</td>
        <td class="accor_value"><?php echo number_format($paySlip->pf); ?></td>
    </tr>
    <tr>
        <td class="accor_label" style="font-weight: bold">total:</td>
        <td class="accor_value" style="font-weight: bold">
        <?php
        echo number_format($paySlip->total);
        ?>
        </td>
    </tr>
</table>