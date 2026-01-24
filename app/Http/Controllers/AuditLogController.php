<?php

namespace App\Http\Controllers;

use App\Contracts\Interface\AuditLogInterface;

class AuditLogController extends Controller
{
    public function __construct(
        protected AuditLogInterface $repo
    ) {}

    public function index()
    {
        $logs = $this->repo->paginate(15);

        return view('audit-logs.index', compact('logs'));
    }
}
