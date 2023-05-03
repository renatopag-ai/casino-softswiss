<?php

if (!function_exists('generateSignature')) {
    function generateSignature($body) {

        $hash = hash_hmac('sha256', json_encode($body), 'dhf4jdsuhzdza69d');
        return $hash;
    }
}

if (!function_exists('validateSignature')) {
    function validateSignature($body, $external_signature) {

        $internal_signature = hash_hmac('sha256', json_encode($body), 'dhf4jdsuhzdza69d');

        // print_r($internal_signature);exit;

        return $internal_signature === $external_signature ? $internal_signature : false;
    }
}

if (!function_exists('convertAmount')) {
    function convertAmount($amount) {

        $amount = $amount / 100;
        return $amount;
    }
}

if (!function_exists('error')) {
    function error($http_code) {
        $message = match ($http_code) {
            // 1xx
            100 => lang('Errors.softswiss.insufficient_funds'),
            101 => lang('Errors.softswiss.invalid_player'),
            105 => lang('Errors.softswiss.customized_bet_limit'),
            106 => lang('Errors.softswiss.max_bet_limit_exceeded'),
            107 => lang('Errors.softswiss.forbidden_game'),
            110 => lang('Errors.softswiss.player_disabled'),
            153 => lang('Errors.softswiss.game_not_available_in_country'),
            154 => lang('Errors.softswiss.currency_not_allowed'),
            155 => lang('Errors.softswiss.forbidden_field_change'),
            // 4xx
            400 => lang('Errors.softswiss.bad_request'),
            403 => lang('Errors.softswiss.forbidden_request'),
            404 => lang('Errors.softswiss.not_found'),
            405 => lang('Errors.softswiss.game_not_available'),
            406 => lang('Errors.softswiss.freespins_not_available'),
            // 5xx
            500 => lang('Errors.softswiss.unknown_error'),
            502 => lang('Errors.softswiss.external_service_error'),
            503 => lang('Errors.softswiss.service_unavailable'),
            504 => lang('Errors.softswiss.request_timed_out'),
            // 6xx
            600 => lang('Errors.softswiss.freespins_unavailable_provider'),
            601 => lang('Errors.softswiss.impossible_issue_freespins'),
            602 => lang('Errors.softswiss.issue_freespins_missing_game'),
            603 => lang('Errors.softswiss.bad_expiration_date'),
            605 => lang('Errors.softswiss.cannot_change_issue_state'),
            606 => lang('Errors.softswiss.cannot_change_issue_state_synced'),
            607 => lang('Errors.softswiss.freespins_multiple_providers'),
            610 => lang('Errors.softswiss.invalid_freespins_issue'),
            611 => lang('Errors.softswiss.expired_freespins_issue'),
            620 => lang('Errors.softswiss.cannot_cancel_freespins_issue'),
            // 7xx
            700 => lang('Errors.softswiss.live_game_unavailable'),
            default => lang('Errors.softswiss.unexpected_error')
        };
        return $message;
    }
}
