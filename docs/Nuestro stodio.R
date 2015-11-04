library(scatterplot3d)

data <- matrix(c(
#Móvil e internet
0,3/7,0,
0,5/7,0/3,
#Nubico e internet
0.5,6/7,2/3,
0.5,2/7,1/3,
#Fusión
1,4/7,1/3,
1,3/7,2/3
),ncol=3,byrow=TRUE)
colnames(data) <- c("Combinatoria", "RI","Azar")
data <- data.frame(data)

data$pcolor[1] <- "red"
data[1,]$pcolor<-"red"
data[2,]$pcolor<-"red"
data[3,]$pcolor<-"orange"
data[4,]$pcolor<-"orange"
data[5,]$pcolor<-"blue"
data[6,]$pcolor<-"blue"


data
with(data, {
   scatterplot3d(Azar,   # x axis
                 RI,     # y axis
                 Combinatoria,    # z axis
                 color=pcolor,
                 main="Representacion 3-D del riesgo")
})
