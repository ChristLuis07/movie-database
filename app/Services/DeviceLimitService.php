<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Support\Str;
use Jenssegers\Agent\Facades\Agent;

class DeviceLimitService
{
    public function registerDevice(User $user)
    {
        $deviceInfo = $this->getDeviceInfo();

        $existingDevice = $this->findExistingDevice($user, $deviceInfo);

        if ($existingDevice) {
            $existingDevice->update(['last_active' => now()]);
            session(['device_id' => $existingDevice->device_id]);
            return $existingDevice;
        }

        if ($this->hasReachDeviceLimit($user)) {
            return false;
        }

        $device = $this->createNewDevice($user, $deviceInfo);
        session(['device_id' => $device->device_id]);
        return $device;
    }

    public function logoutDevice($deviceId)
    {
        UserDevice::where('device_id', $deviceId)->delete();
        session()->forget('device_id');
    }

    private function getDeviceInfo()
    {
        return [
            'device_name' => $this->generateDeviceName(),
            'device_type' => Agent::isDesktop() ? 'desktop' : (Agent::isMobile() ? 'phone' : 'tablet'),
            'platform' => $this->getValidPlatform(),
            'platform_version' => Agent::version(Agent::platform()) ?: 'Unknown Version',
            'browser' => $this->getValidBrowser(),
            'browser_version' => Agent::version(Agent::browser()) ?: 'Unknown Version',
        ];
    }

    private function generateDeviceName()
    {
        return ucfirst($this->getValidPlatform()) . ' ' . ucfirst($this->getValidBrowser());
    }

    private function getValidPlatform()
    {
        $platform = Agent::platform();
        return ($platform && trim($platform) !== '') ? $platform : 'Unknown OS';
    }

    private function getValidBrowser()
    {
        $browser = Agent::browser();
        return ($browser && trim($browser) !== '') ? $browser : 'Unknown Browser';
    }

    private function findExistingDevice(User $user, array $deviceInfo)
    {
        return UserDevice::where('user_id', $user->id)
            ->where('device_type', $deviceInfo['device_type'])
            ->where('platform', $deviceInfo['platform'])
            ->where('browser', $deviceInfo['browser'])
            ->first();
    }

    private function hasReachDeviceLimit(User $user)
    {
        $maxDevices = $user->getCurrentPlan()->max_devices ?? 1;
        return UserDevice::where('user_id', $user->id)->count() >= $maxDevices;
    }

    private function createNewDevice(User $user, array $deviceInfo)
    {
        return UserDevice::create([
            'user_id' => $user->id,
            'device_name' => $deviceInfo['device_name'],
            'device_id' => $this->generateDeviceId(),
            'device_type' => $deviceInfo['device_type'],
            'platform' => $deviceInfo['platform'],
            'platform_version' => $deviceInfo['platform_version'],
            'browser' => $deviceInfo['browser'],
            'browser_version' => $deviceInfo['browser_version'],
            'last_active' => now(),
        ]);
    }

    private function generateDeviceId()
    {
        return Str::random(32);
    }
}
