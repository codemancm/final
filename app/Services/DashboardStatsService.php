<?php

namespace App\Services;

use App\Models\Dispute;
use App\Models\Orders;
use App\Models\Transaction;
use Illuminate\Support\Facades\Cache;

class DashboardStatsService
{
    /**
     * Get the statistics for the admin dashboard.
     *
     * @return array
     */
    public function getStats()
    {
        return Cache::remember('admin_dashboard_stats', now()->addMinutes(10), function () {
            return [
                'xmr_transaction_volume' => $this->getXmrTransactionVolume(),
                'escrow_status' => $this->getEscrowStatus(),
                'disputes' => $this->getDisputeStats(),
            ];
        });
    }

    /**
     * Get the XMR transaction volume.
     *
     * @return array
     */
    protected function getXmrTransactionVolume()
    {
        return [
            'daily' => Transaction::where('created_at', '>=', now()->subDay())->sum('amount'),
            'weekly' => Transaction::where('created_at', '>=', now()->subWeek())->sum('amount'),
            'monthly' => Transaction::where('created_at', '>=', now()->subMonth())->sum('amount'),
        ];
    }

    /**
     * Get the escrow status.
     *
     * @return array
     */
    protected function getEscrowStatus()
    {
        return [
            'total_escrowed' => Orders::where('status', 'in_escrow')->sum('total'),
        ];
    }

    /**
     * Get the dispute statistics.
     *
     * @return array
     */
    protected function getDisputeStats()
    {
        return [
            'open' => Dispute::where('status', 'open')->count(),
            'resolved' => Dispute::where('status', 'resolved')->count(),
        ];
    }
}
