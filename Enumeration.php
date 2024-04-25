<?php

// Définition de l'énumération pour les types de monnaies
abstract class Currency {
    const CHF = "Franc Suisse";
    const EUR = "Euro";
    const USD = "US Dollar";
    const CAD = "Canadian Dollar";
    const ANG = "Florin Antillais";
    const GBP = "Livre Sterling";
}

// Classe pour le calcul des conversions
class CurrencyConverter {
    private $exchangeRates;

    // Constructeur prenant en paramètre les taux de change
    public function __construct($exchangeRates) {
        $this->exchangeRates = $exchangeRates;
    }

    // Méthode de conversion
    public function convert($amount, $fromCurrency, $toCurrency) {
        if (!isset($this->exchangeRates[$fromCurrency]) || !isset($this->exchangeRates[$fromCurrency][$toCurrency])) {
            throw new Exception("Taux de change non disponible pour cette conversion.");
        }

        $rate = $this->exchangeRates[$fromCurrency][$toCurrency];
        if (!is_numeric($amount) || $amount < 0) {
            throw new InvalidArgumentException("Le montant doit être un nombre positif.");
        }

        return $amount * $rate;
    }
}

// Définition des taux de change (vous pouvez les charger à partir d'une source externe si nécessaire)
$exchangeRates = array(
    Currency::USD => array(
        Currency::CHF => 0.92,
        Currency::EUR => 0.82,
        Currency::CAD => 1.25,
        Currency::ANG => 1.79,
        Currency::GBP => 0.72
    ),
    Currency::CHF => array(
        Currency::USD => 1.09,
        Currency::EUR => 0.89,
        Currency::CAD => 1.35,
        Currency::ANG => 1.94,
        Currency::GBP => 0.78
    ),
    Currency::EUR => array(
        Currency::USD => 1.22,
        Currency::CHF => 1.13,
        Currency::CAD => 1.51,
        Currency::ANG => 2.17,
        Currency::GBP => 0.88
    ),
    Currency::CAD => array(
        Currency::USD => 0.80,
        Currency::CHF => 0.74,
        Currency::EUR => 0.66,
        Currency::ANG => 1.44,
        Currency::GBP => 0.58
    ),
    Currency::ANG => array(
        Currency::USD => 0.56,
        Currency::CHF => 0.51,
        Currency::EUR => 0.46,
        Currency::CAD => 0.69,
        Currency::GBP => 0.40
    ),
    Currency::GBP => array(
        Currency::USD => 1.39,
        Currency::CHF => 1.28,
        Currency::EUR => 1.14,
        Currency::CAD => 1.72,
        Currency::ANG => 2.50
    )
);

// Création de l'instance du convertisseur
$converter = new CurrencyConverter($exchangeRates);

// Montant à convertir
$amount = 1000;

// Devise source
$fromCurrency = Currency::USD;

// Devise cible
$currencies = array(
    Currency::CHF,
    Currency::EUR,
    Currency::CAD,
    Currency::ANG,
    Currency::GBP
);

// Conversion pour chaque devise cible et affichage des résultats
foreach ($currencies as $toCurrency) {
    try {
        $convertedAmount = $converter->convert($amount, $fromCurrency, $toCurrency);
        echo "$amount $fromCurrency équivaut à $convertedAmount $toCurrency.\n";
    } catch (InvalidArgumentException $e) {
        echo "Erreur: " . $e->getMessage() . "\n";
    } catch (Exception $e) {
        echo "Erreur: " . $e->getMessage() . "\n";
    }
}

?>
