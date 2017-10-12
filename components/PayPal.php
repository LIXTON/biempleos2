<?php
namespace app\components;

require 'paypal/autoload.php';

use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

use Yii;
use yii\helpers\Url;
use app\models\Paquete;
use app\models\EmpresaPaquete;

class PayPal {
	public static function checkout($paquete) {
		$successUrl = Url::toRoute(['//empresa-paquete/confirmar-pago', 'state' => 'success']);
		$failureUrl = Url::toRoute(['//empresa-paquete/confirmar-pago', 'state' => 'fail']);

		$paypal = new \PayPal\Rest\ApiContext(
		new \PayPal\Auth\OAuthTokenCredential(
			'AbwN-3Ept9f7BxgTIwUaazVltJC5EjLmJ5zUPipJsPOvL-eVjWfi4Hj1An3AeXttHm_spej8n6fjTkhI',
			'EPnqiFsy_CmboIluDH3b81EfcbeDVxSJdn3vDJnIEWn8tZwG94oSjlcAUTpK5BfH9JPQuMsu_tjitbZY'
			)
		);
        
        /*$paypal->setConfig(
			array(
				'mode' => 'live',
				'log.LogEnabled' => true,
				'log.FileName' => '../PayPal.log',
				'log.LogLevel' => 'DEBUG',
				'validation.level' => 'log',
				'cache.enabled' => true,
			)
		);*/

		$payer = new Payer();
		$payer->setPaymentMethod('paypal');
        
        $paquete = Paquete::find()
            ->joinWith('oferta')
            ->where(['id' => $paquete]);
        
        $precio = $paquete->precio;
        
        if ($paquete->oferta !== null) {
            $empresaPaquete = EmpresaPaquete::find()
                ->where(['id_paquete' => $paquete, 'id_empresa' => Yii::$app->user->id])
                ->andWhere('fecha_expiracion >= :fecha', [':fecha' => date('Y-m-d H:i:s')])
                ->all();
            $oferta = '';

            if (count($empresaPaquete) == 0) {
                $oferta = $paquete->oferta->descuento;
            } else {
                foreach($empresaPaquete as $ep) {
                    if ($paquete->oferta->paquete_padre == $ep->id_paquete) {
                        $oferta = $paquete->oferta->descuento;
                        break;
                    }
                }
            }

            if (stripos($oferta, "%") !== false) {
                preg_match("|\d+|", $oferta, $m);
                $precio = $precio * ((double)(100 - $m[0])/100);
            } else if (stripos($oferta, "$") !== false) {
                $precio = number_format(str_replace('$', '', $oferta), 2, '.', '');
            }
        }
        
        $item = new Item();
        $item->setName($paquete->nombre)
             ->setCurrency('MXN')
             ->setQuantity(1)
             ->setPrice($precio);
        
        $itemList = new ItemList();
		$itemList->setItems(array($item));

		$details = new Details();
		$details->setSubtotal($precio);

		$amount = new Amount();
		$amount->setCurrency('MXN')
		       ->setTotal($precio)
		       ->setDetails($details);

		$transaction = new Transaction();
		$transaction->setAmount($amount)
		            ->setItemList($itemList)
		            ->setDescription($paquete->nombre)
		            ->setInvoiceNumber(uniqid());

		$redirectUrls = new RedirectUrls();
		$redirectUrls->setReturnUrl($successUrl)
		             ->setCancelUrl($failureUrl);

		$payment = new Payment();
		$payment->setIntent('sale')
		        ->setPayer($payer)
		        ->setRedirectUrls($redirectUrls)
		        ->setTransactions([$transaction]);

		try {
			$payment->create($paypal);
		} catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo "<pre>" . $ex->getCode(); // Prints the Error Code
            echo $ex->getData() . "</pre>"; // Prints the detailed error message 
            die($ex);
        } catch (Exception $e) {
			die($e);
		}

		$approvalUrl = $payment->getApprovalLink();

		header("Location: {$approvalUrl}");
	}

	public static function process($paymentID, $payerID) {
		$paypal = new \PayPal\Rest\ApiContext(
		new \PayPal\Auth\OAuthTokenCredential(
			'AbwN-3Ept9f7BxgTIwUaazVltJC5EjLmJ5zUPipJsPOvL-eVjWfi4Hj1An3AeXttHm_spej8n6fjTkhI',
			'EPnqiFsy_CmboIluDH3b81EfcbeDVxSJdn3vDJnIEWn8tZwG94oSjlcAUTpK5BfH9JPQuMsu_tjitbZY'
			)
		);

		$payment = Payment::get($paymentID, $paypal);
		$execute = new PaymentExecution();
		$execute->setPayerId($payerID);

		try {
			$result = $payment->execute($execute, $paypal);
		} catch (Exception $e) {
			$data = json_decode($e->getData());
			echo $data->message;
			return false;
		}

		return true;
	}
}
?>