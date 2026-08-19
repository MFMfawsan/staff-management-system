# Deployment

## Important architecture note

This repository is a server-rendered PHP application. The HTML UI and PHP form handlers live in the same files, and the app uses PHP sessions. There is no independent static frontend or JSON API to deploy to Vercel without rewriting the application.

To keep the existing UI and functionality unchanged, deploy the complete app to Railway. `FRONTEND_URL` and CORS headers are prepared for a future separate browser frontend, but the current app does not need cross-origin requests because its UI and PHP handlers are same-origin.

## Local preparation

1. Copy `.env.example` to `.env`.
2. Fill in the MySQL values.
3. Import `database/schema.sql` into MySQL.
4. Run the app through Apache/PHP, not a static file server.

## Railway deployment

1. Push these prepared files to the `MFMfawsan/staff-management-system` repository.
2. In Railway, create a new project and deploy the GitHub repository.
3. Railway will use `Dockerfile` and `railway.toml`.
4. Add a MySQL service to the same Railway project. The healthcheck uses `/health.php`, which does not require the database and only confirms that Apache/PHP is responding.
5. Import `database/schema.sql` into the Railway MySQL database.
6. Add these variables to the PHP service, using the values shown by the Railway MySQL service:
   - `DB_HOST`
   - `DB_PORT`
   - `DB_NAME`
   - `DB_USER`
   - `DB_PASSWORD`
   - `FRONTEND_URL` only if a separate browser frontend is later created
7. Deploy and open the generated Railway domain. The login page is `/login.php`.

Railway filesystems are ephemeral unless a volume is attached. For profile images, add a Railway volume mounted at `/var/www/html/assets/uploads/profile_pics`, or move uploads to object storage before production. The upload handler now accepts only JPEG, PNG, GIF, and WebP files up to 5 MB and generates safe random filenames.

## Vercel clarification

Vercel does not run this PHP application as a normal PHP server. Do not deploy this repository as a Vercel frontend and expect the existing login/forms to work. A Vercel frontend would require a separate JavaScript client and PHP API endpoints, which would change the current architecture and functionality.

If that split is required later:

1. Build a separate frontend that calls explicit PHP API endpoints.
2. Deploy that frontend to Vercel.
3. Set `FRONTEND_URL` on Railway to the exact Vercel URL.
4. Use `credentials: 'include'` for session requests and configure HTTPS cookie settings.
5. Test login, CRUD, attendance, and image uploads end to end.

## Final checks

- Open the Railway URL and log in.
- Test dashboard counts, staff list search, add/edit/delete, departments, and attendance.
- Upload a valid profile image and confirm it displays after refresh.
- Test an invalid file type and a file larger than 5 MB.
- Confirm the database persists after a redeploy.
- Confirm the Railway volume or object storage preserves uploaded images.
