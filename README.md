# WordPress on App Engine Standard Setup Steps

## Prerequisites:
 1. Installed PHP 7.2+
 2. GCP project with enabled billing
 3. [Installed Cloud SDK](https://cloud.google.com/sdk)
 4. [Enabled Cloud SQL API](https://console.cloud.google.com/flows/enableapi?apiid=sqladmin&_ga=2.148049013.37051970.1620957592-1933320711.1616784360)
 5. [Enabled Cloud Scheduler](https://console.cloud.google.com/cloudscheduler)
 6. [Enabled Cloud Console Storage](https://console.cloud.google.com/storage)
 7. [Installed Composer for managing dependencies](https://getcomposer.org/download/)

## GCP Setup

### Automatic Configuration

#### Initial Provisioning

Run `make create-wp-provisioning`. This will create all required resources in GCP for WordPress.

#### Update Provisioning

Run `make update-wp-provisioning`. This will update resources in GCP.

#### Delete Provisioning

Run `make delete-wp-provisioning`. This will delete all resources in GCP related with WordPress.

### Manual Configuration

If for some reason the automatic configuration does not work, you can manually configure the following:

#### Cloud SQL instance to use MySQL database
 1. First step would be to create MySQL instance: <br> 
`gcloud sql instances create ae-wordpress \
 --activation-policy=ALWAYS \
 --tier=db-n1-standard-1 \
 --region=us-central1 \
 --project=sk-borislav  Replace with own GCP project name`
2. Then we create the database for WordPress: **gcloud sql databases create WordPress --instance ae-wordpress**
3. After that we set new password for root user: <br>
`gcloud sql users set-password root \
--host=% \
--instance wordpress \
--password=f$BsUk@uZunP9GDq # Use your password`

#### Create Cloud Storage bucket
1. Go to [Cloud Console Storage](https://console.cloud.google.com/storage) page and create a bucket with Access control permission to be fine-grained
2. Change the default Access Control List of the bucket - **gsutil defacl ch -u AllUsers:R gs://<your_bucket_name>**

## Create a WordPress project for App Engine
1. Run this command just in case you are missing these extensions **sudo apt-get install php7.2-zip php7.2-curl**
2. Setup **wp-gae** – needed in order WordPress to interact with AppEngine. It is provided by Google and is useful for creating new WordPress project or add required configuration to an existing one:
**composer global require google/cloud-tools**
3. Execute **composer global config bin-dir -absolute** – this should print a dir where your binaries were installed by the **composer** program then go to your **.bashrc** or its equivalent depending on your OS and update your **PATH** export to include the printed result from the above command
4. Run **wp-gae create** then answer all the questions you are asked – for database region use this **gcloud sql instances describe created_instance_from_above_steps | grep region**. If everything was successful you should see something like this <br>
<img src="/assets/images/img1.png">

## Deploy to GCP
Go to the created project **cd created_project_path** and the run **make deploy**.

## Enable the Google Cloud Storage plugin
App Engine file system is read-only, so it is not possible to upload any files directly, but this problem is solved when you install the [Google Cloud Storage plugin](https://wordpress.org/plugins/gcs/):
1. Go to the Dashboard at https://YOUR_PROJECT_ID.appspot.com/wp-admin. On the Plugins page, Activate the **Google Cloud Storage plugin**. <br>
<img src="/assets/images/img2.png"/>
2. Click Activate button <br>
3. After the activation there will be Settings button click it, and you would be redirected to a page where you need to put your [bucket name you created](#create-cloud-storage-bucket). After that you should be able to upload files. <br>
<img src='/assets/images/img3.png'/>

## Install and update WordPress plugins and themes
Because the **wp-content** directory on the server is read-only, you have to perform all code updates locally. Run WordPress locally and update the plugins and themes in the local Dashboard, deploy the code, then activate them in the deployed Dashboard.