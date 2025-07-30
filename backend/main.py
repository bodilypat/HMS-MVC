# backend/main.py

from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from app.routes.api import api_router
from app.config.database import create_db_and_tables

app = FastAPI(
               title="Hotel Management System API",
               version="1.0.0",
               description="Backend API for managing hotel operations (rooms, booking, users, etc.')"
            )
            
# Allow frontend to access the API (CORS)
app.add_middleware(
        CORSMiddleware,
        allow_origins=["*"], # Change to your frontend URL in production 
        allow_credentials=True,
        allow_method=["*"],
        allow_headers["*"],
    )
    
# Register API routes
app.include_router(api_router, prefix="/api/v1")

# Event handlers
@app.on.event("startup")
async def startup():
    print("Starting up...")
    create_db_and_tables()
    print("Database connected and readly.")
    
    @app.on_event("shutdown")
    async def shutdown():
        print("Shutting down...")
        
