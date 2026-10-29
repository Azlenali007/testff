<?php
/**
 * Order Service
 * N.A Fresh Fruits & Coconuts
 */

class OrderService {
    public static function processCheckout(array $postData): array {
        // CSRF Check
        if (!verify_csrf_token($postData[CSRF_TOKEN_KEY] ?? '')) {
            return ['success' => false, 'error' => 'Security token expired. Please refresh and try again.'];
        }

        // Validate Customer Info
        $name = trim($postData['customer_name'] ?? '');
        $phone = trim($postData['customer_phone'] ?? '');
        $fulfilment = trim($postData['fulfilment_method'] ?? 'delivery');
        $address = trim($postData['delivery_address'] ?? '');
        $paymentMethod = trim($postData['payment_method'] ?? 'cod');

        if (empty($name) || strlen($name) < 2) {
            return ['success' => false, 'error' => 'Please enter your full name.'];
        }

        // Clean Indian phone number
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($cleanPhone) < 10) {
            return ['success' => false, 'error' => 'Please enter a valid 10-digit mobile number.'];
        }

        if ($fulfilment === 'delivery' && (empty($address) || strlen($address) < 8)) {
            return ['success' => false, 'error' => 'Please provide a complete delivery address including street and locality.'];
        }

        if (!in_array($fulfilment, ['delivery', 'pickup'])) {
            $fulfilment = 'delivery';
        }

        if (!in_array($paymentMethod, ['cod', 'online'])) {
            $paymentMethod = 'cod';
        }

        $cart = CartService::getCart();
        if (empty($cart['items'])) {
            return ['success' => false, 'error' => 'Your cart is empty. Please add fresh coconut water before checking out.'];
        }

        $orderData = [
            'customer_name' => $name,
            'customer_phone' => $phone,
            'fulfilment_method' => $fulfilment,
            'delivery_address' => $address,
            'payment_method' => $paymentMethod,
            'idempotency_key' => $postData['idempotency_key'] ?? null,
            'notes' => trim($postData['notes'] ?? '')
        ];

        $result = Order::createOrder($orderData, $cart['items']);

        if ($result['success']) {
            // Clear cart upon successful order
            CartService::clear();
        }

        return $result;
    }
}
