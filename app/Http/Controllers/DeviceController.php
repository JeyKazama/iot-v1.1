<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Dht22;

class DeviceController extends Controller
{
    // Get current device status
    public function getDeviceStatus()
    {
        $device = Device::first();
        
        if (!$device) {
            // Create default device if not exists
            $device = Device::create([
                'kipas' => 0,
                'ac' => 0,
                'air_purifier' => 0,
                'led1' => 0,
                'led2' => 0,
                'led3' => 0,
                'kipas_auto' => 0,
                'ac_auto' => 0,
                'air_purifier_auto' => 0,
            ]);
        }

        // Check auto mode logic
        $this->checkAutoMode($device);

        return response()->json($device);
    }

    // Update device status (Manual mode)
    public function updateDevice(Request $request)
    {
        $device = Device::first();
        
        if (!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        $column = $request->column;
        $status = $request->status;

        // Update device status
        $device->update([
            $column => $status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Device updated successfully',
            'device' => $device
        ]);
    }

    // Update device mode (Auto/Manual)
    public function updateDeviceMode(Request $request)
    {
        $device = Device::first();
        
        if (!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        $column = $request->column;
        $mode = $request->mode;

        // Update mode
        $device->update([
            $column => $mode
        ]);

        // If switching to auto, immediately apply auto logic
        if ($mode == 1) {
            $this->checkAutoMode($device);
        }

        return response()->json([
            'success' => true,
            'message' => 'Mode updated successfully',
            'device' => $device
        ]);
    }

    // Check and apply auto mode logic
    private function checkAutoMode($device)
    {
        // Get latest sensor data
        $sensor = Dht22::orderBy('created_at', 'desc')->first();
        
        if (!$sensor) {
            return;
        }

        $temperature = $sensor->temperature;
        $humidity = $sensor->humidity;
        $maxTemp = $sensor->max_temperature ?? 30;
        $maxHumidity = $sensor->max_humidity ?? 70;

        // Auto mode logic: Turn ON if temperature/humidity < maximum
        
        // Kipas Auto
        if ($device->kipas_auto == 1) {
            if ($temperature < $maxTemp) {
                $device->kipas = 1;
            } else {
                $device->kipas = 0;
            }
        }

        // AC Auto
        if ($device->ac_auto == 1) {
            if ($temperature < $maxTemp) {
                $device->ac = 1;
            } else {
                $device->ac = 0;
            }
        }

        // Air Purifier Auto
        if ($device->air_purifier_auto == 1) {
            if ($temperature < $maxTemp) {
                $device->air_purifier = 1;
            } else {
                $device->air_purifier = 0;
            }
        }

        $device->save();
    }
}