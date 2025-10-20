@extends('templates.app')

@section('title', 'Checkout') 

@section('content')

<style>
    body {
        background-color: #FFFEFA; 
        font-family: Arial, sans-serif; 
        color: #374151; 
    }

    .page-container {
        padding-top: 3rem;
        padding-bottom: 3rem;
    }
    
    .checkout-container {
        width: 100%;
        max-width: 1280px;
        margin-left: auto;
        margin-right: auto;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr; 
        gap: 2rem; 
    }

    .checkout-main {
        display: flex;
        flex-direction: column;
        gap: 2rem; 
    }

    .checkout-sidebar {
    
    }

    @media (min-width: 1024px) {
        .checkout-grid {
         
            grid-template-columns: repeat(3, 1fr);
        }
        .checkout-main {
            grid-column: span 2 / span 2; 
        }
        .checkout-sidebar {
            grid-column: span 1 / span 1; 
        }
    }

    .checkout-box {
        background-color: #ffffff;
        border-radius: 0.75rem; 
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); 
        border: 1px solid #9CA3AF; 
        padding: 1.5rem; 
    }

    .product-box {
        padding: 1rem; 
        height: 100%;
        box-sizing: border-box; 
    }

    .product-box-inner {
        display: flex;
        align-items: center;
        gap: 1.5rem; 
    }

    @media (max-width: 640px) {
        .product-box-inner {
            flex-direction: column;
            gap: 1rem;
        }
    }

    .product-image {
        width: 10rem;
        height: 10rem;
        object-fit: cover;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .product-details {
        flex-grow: 1; 
        width: 100%;
        padding: 1rem;
    }

    .product-title,
    .box-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1F2937;
        margin-bottom: 0.5rem;
    }

    .product-description {
        color: #374151;
        margin-bottom: 2rem;
    }

    .product-price {
        font-weight: 700;
        font-size: 1.25rem;
        text-align: right;
        color: #1F2937;
    }

    .address-line {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .address-icon {
        width: 1.25rem;
        height: 1.25rem;
        margin-top: 0.25rem;
        flex-shrink: 0;
    }

    .payment-title {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .payment-options {
        display: flex;
        align-items: center;
        gap: 1rem;
        max-width: 20rem;
    }

    .payment-option-btn {
        flex: 1; 
        height: 4rem;
        padding: 0.75rem;
        border: 2px solid #9CA3AF;
        box-sizing: border-box;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #fff;
        cursor: pointer;
        transition: border-color 0.3s ease;
    }
    .payment-option-btn:hover {
        border-color: #FBBF24; 
    }

    .payment-option-img {
    width: 8rem;          
    height: auto;          
    object-fit: contain;   
    display: block;
    }

    .total-box {
        height: 100%;
        display: flex;
        flex-direction: column;
        box-sizing: border-box; 
    }

    .total-summary {
        flex-grow: 1; 
        color: #374151;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem; 
    }

    .total-final-line {
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        font-size: 1.125rem;
        color: #1F2937;
        margin-top: 1rem; 
    }

    .pay-button {
        width: 100%;
        background-color: #111827; 
        color: #ffffff; 
        font-weight: 700;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        margin-top: 1.5rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    .pay-button:hover {
        background-color: #1F2937; 
    }
</style>

@php
    $product = [
        'name' => 'Bakpia Durian',
        'image_url' => 'images/bakpiadurian.png', 
        'quantity_text' => '10, Bakpia Durian',
        'price' => 250000,
    ];
    $shippingCost = 10000;
@endphp

<div class="page-container">
    <div class="checkout-container">
        
        <div class="checkout-grid">

            <div class="checkout-main">

                <div class="checkout-box product-box">
                    <div class="product-box-inner">
                        
                        <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}" class="product-image">
                        
                        <div class="product-details">
                            <h2 class="product-title">Pembelian Barang</h2>
                            <p class="product-description">{{ $product['quantity_text'] }}</p>
                            <p class="product-price">
                                Rp{{ number_format($product['price'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="checkout-box address-box">
                    <h3 class="box-title">Alamat Pengiriman:</h3>
                    <div class="address-line">
                        
                        <img src="images/lokasi.png" alt="Lokasi" class="address-icon">
                        
                        <p>Kampus III Universitas Sanata Dharma, Jl. Paingan, Krodan, Maguwoharjo, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281</p>
                    </div>
                    
                    <h3 class="box-title payment-title">Pilih Metode Pembayaran:</h3>
                    <div class="payment-options">
                        
                        <button class="payment-option-btn">
                            <img src="images/qris2.png" alt="QRIS" class="payment-option-img">
                        </button>
                        <button class="payment-option-btn">
                            <img src="images/Bank2.png" alt="Bank Transfer" class="payment-option-img" >
                        
                        </button>
                    </div>
                </div>
            </div>

            <div class="checkout-sidebar">
                <div class="checkout-box total-box">
                    <div class="total-summary">
                        <div class="summary-line">
                            <span>Total Pesanan (1 Menu)</span>
                            <span>Rp{{ number_format($product['price'], 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-line">
                            <span>Total Biaya Pengiriman</span>
                            <span>Rp{{ number_format($shippingCost, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="total-final-line">
                        <span>Total</span>
                        <span>Rp{{ number_format($product['price'], 0, ',', '.') }}</span>
                    </div>
                    <button class="pay-button">
                        Bayar Sekarang
                    </button>
                </div>
            </div>

        </div> </div>
</div>

@endsection