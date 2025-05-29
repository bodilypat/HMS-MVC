<?php
    $router->get('/room-types', [RoomTypeController::class, 'index']);
    $router->get('/room-types', [RoomTypeController::class, 'show']);
    $router->post(/room-types', [RoomTypeController::class, 'store']);
    $router->put('/room-types', [RoomTypeController::class, 'update']);
    $router->delete('/room-types', [RoomTypeControl::class, 'destroy']);
